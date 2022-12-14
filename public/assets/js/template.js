(function ($) {
    "use strict"; $('[data-toggle="tooltip"]').tooltip()
    $('.light-dark-toggle').on('click', function () { $(this).toggleClass('active') }); $('.rightbar .rightbar-link').on('click', function () { $('.rightbar').addClass('open') }); $('.rightbar .close-sidebar').on('click', function () { $('.rightbar').removeClass('open') }); $('.chat-body .show-user-detail').on('click', function () { $('.main ').toggleClass('open-chat-sidebar') }); $('.close-chat-sidebar').on('click', function () { $('.main ').removeClass('open-chat-sidebar') }); $('.chat-body .add-user-btn').on('click', function () { $('.main ').toggleClass('open-user-sidebar') }); $('.close-chat-sidebar').on('click', function () { $('.main ').removeClass('open-user-sidebar') }); $('.sidebar-toggle-btn').on('click', function () { $('body ').toggleClass('open-sidebar-menu') }); $(document).ready(function () { $('.choose-skin li').on('click', function () { var $body = $('#layout'); var $this = $(this); var existTheme = $('.choose-skin li.active').data('theme'); $('.choose-skin li').removeClass('active'); $body.removeClass('theme-' + existTheme); $this.addClass('active'); var newTheme = $('.choose-skin li.active').data('theme'); $body.addClass('theme-' + $this.data('theme')); }); }); $(document).ready(function () {
        $('.menu-toggle').on('click', function (e) {
            var $this = $(this); var $content = $this.next(); if ($($this.parents('ul')[0]).hasClass('list')) { var $not = $(e.target).hasClass('menu-toggle') ? e.target : $(e.target).parents('.menu-toggle'); $.each($('.menu-toggle.toggled').not($not).next(), function (i, val) { if ($(val).is(':visible')) { $(val).prev().toggleClass('toggled'); $(val).slideUp(); } }); }
            $this.toggleClass('toggled'); $content.slideToggle(320);
        });
    }); $('#mini-calendar').datepicker({
        todayHighlight: true, beforeShowDay: function (date) {
            if (date.getMonth() == (new Date()).getMonth())
                switch (date.getDate()) { case 0: return { tooltip: 'Example tooltip', classes: 'active' }; case 0: return false; case 0: return "green"; }
        }
    });
})(jQuery);