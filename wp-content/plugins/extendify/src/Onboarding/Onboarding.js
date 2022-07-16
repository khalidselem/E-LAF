import { useSelect } from '@wordpress/data'
import { useEffect, useState } from '@wordpress/element'
import { SWRConfig, useSWRConfig } from 'swr'
import { RetryNotice } from '@onboarding/components/RetryNotice'
import { useDisableWelcomeGuide } from '@onboarding/hooks/useDisableWelcomeGuide'
import { useBodyScrollLock } from '@onboarding/hooks/useScrollLock'
import { CreatingSite } from '@onboarding/pages/CreatingSite'
import { Finished } from '@onboarding/pages/Finished'
import { useGlobalStore } from '@onboarding/state/Global'
import { usePagesStore } from '@onboarding/state/Pages'
import { useUserSelectionStore } from '@onboarding/state/UserSelections'
import { useTelemetry } from './hooks/useTelemetry'
import { NeedsTheme } from './pages/NeedsTheme'

export const Onboarding = () => {
    const resetState = useUserSelectionStore((state) => state.resetState)
    const [retrying, setRetrying] = useState(false)
    const { component: CurrentPage } = usePagesStore((state) =>
        state.currentPageData(),
    )
    const { fetcher, fetchData } = usePagesStore((state) =>
        state.nextPageData(),
    )
    const { mutate } = useSWRConfig()
    const generating = useGlobalStore((state) => state.generating)
    const generatedPages = useGlobalStore((state) => state.generatedPages)
    const [show, setShow] = useState(false)
    const [needsTheme, setNeedsTheme] = useState(false)
    const theme = useSelect((select) => select('core').getCurrentTheme())
    useDisableWelcomeGuide()
    useBodyScrollLock()
    useTelemetry()

    const page = () => {
        if (needsTheme) return <NeedsTheme />
        if (Object.keys(generatedPages)?.length) return <Finished />
        if (generating) return <CreatingSite />
        return <CurrentPage />
    }

    useEffect(() => {
        // Check that the textdomain came back and that it's extendable
        if (!theme?.textdomain) return
        if (theme?.textdomain === 'extendable') return
        setNeedsTheme(true)
    }, [theme])

    useEffect(() => {
        if (!show) return
        // If the library happens to be open, try to close it.
        const timeout = setTimeout(() => {
            window.dispatchEvent(
                new CustomEvent('extendify::close-library', { bubbles: true }),
            )
        }, 0)
        document.title = 'Extendify Launch' // Don't translate
        return () => clearTimeout(timeout)
    }, [show])

    useEffect(() => {
        resetState()
        const q = new URLSearchParams(window.location.search)
        setShow(['onboarding'].includes(q.get('extendify')))
    }, [resetState])

    useEffect(() => {
        if (fetcher) {
            mutate(fetchData, fetcher)
        }
    }, [fetcher, mutate, fetchData])

    if (!show) return null

    return (
        <SWRConfig
            value={{
                errorRetryInterval: 1000,
                onErrorRetry: (error, key) => {
                    console.error(key, error)
                    if (error?.data?.status === 403) {
                        // if they are logged out, we can't recover
                        window.location.reload()
                        return
                    }
                    if (retrying) return
                    setRetrying(true)
                    setTimeout(() => {
                        setRetrying(false)
                    }, 5000)
                },
            }}>
            <div
                style={{ zIndex: 99999 + 1 }} // 1 more than the library
                className="h-screen w-screen fixed inset-0 overflow-y-auto md:overflow-hidden bg-white">
                {page()}
            </div>
            {retrying && <RetryNotice />}
        </SWRConfig>
    )
}