"use strict";

jQuery(function ($) {
  var vczapi_script = {
    init: function init() {
      this.cacheDOM();
      this.eventListeners();
    },
    cacheDOM: function cacheDOM() {
      this.wooEnable = $('.vczapi-enable-woocommerce-purchase');
      this.showOnChecked = $('.show-on-checked');
    },
    eventListeners: function eventListeners() {
      this.wooEnable.on('click', this.showHideSection.bind(this));
    },
    showHideSection: function showHideSection(e) {
      if ($(e.currentTarget).is(':checked')) {
        $(this.showOnChecked).show();
      } else {
        var result = confirm('A new WoooCommerce product will be created next time you check this again. Proceed ?');

        if (result) {
          $(this.showOnChecked).hide();
        } else {
          $(e.currentTarget).prop('checked', true);
        }
      }
    }
  };
  vczapi_script.init();
});