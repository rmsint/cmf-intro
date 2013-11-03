(function ($, window, undefined) {
    'use strict';

    var currentPath = $(location).attr('pathname');

    $(document).ready(function () {
        //set main menu current item
        $("header ul.navbar-nav a[href='" + currentPath + "']")
            .closest('li').addClass('active')
            .parentsUntil('nav.top-bar', 'li').addClass('active')
        ;

        //set sub menu current item
        $("div.acme-sidebar ul.acme-sidenav a[href='" + currentPath + "']")
            .closest('li').addClass('active')
            .parentsUntil('nav.top-bar', 'li').addClass('active')
        ;
    });

})(jQuery, this);