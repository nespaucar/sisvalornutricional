<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Models\Menuoptioncategory;
use App\Models\Bitacora;
use App\Librerias\Libreria;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MenuoptioncategoryController extends Controller
{
    protected $folderview      = 'app.menuoptioncategory';
    protected $tituloAdmin     = 'Categoría opción menú';
    protected $tituloRegistrar = 'Registrar categoría';
    protected $tituloModificar = 'Modificar categoría';
    protected $tituloEliminar  = 'Eliminar categoría';
    protected $rutas           = array('create' => 'menuoptioncategory.create', 
        'edit'   => 'menuoptioncategory.edit', 
        'delete' => 'menuoptioncategory.eliminar',
        'search' => 'menuoptioncategory.buscar',
        'index'  => 'menuoptioncategory.index',
    );

    protected $cboIconos = array("fa fa-address-book" => "fa fa-address-book",
        "fa fa-address-book-o" => "fa fa-address-book-o",
        "fa fa-address-card" => "fa fa-address-card",
        "fa fa-address-card-o" => "fa fa-address-card-o",
        "fa fa-adjust" => "fa fa-adjust",
        "fa fa-american-sign-language-interpreting" => "fa fa-american-sign-language-interpreting",
        "fa fa-anchor" => "fa fa-anchor",
        "fa fa-archive" => "fa fa-archive",
        "fa fa-area-chart" => "fa fa-area-chart",
        "fa fa-arrows" => "fa fa-arrows",
        "fa fa-arrows-h" => "fa fa-arrows-h",
        "fa fa-arrows-v" => "fa fa-arrows-v",
        "fa fa-asl-interpreting" => "fa fa-asl-interpreting",
        "fa fa-assistive-listening-systems" => "fa fa-assistive-listening-systems",
        "fa fa-asterisk" => "fa fa-asterisk",
        "fa fa-at" => "fa fa-at",
        "fa fa-audio-description" => "fa fa-audio-description",
        "fa fa-automobile" => "fa fa-automobile",
        "fa fa-balance-scale" => "fa fa-balance-scale",
        "fa fa-ban" => "fa fa-ban",
        "fa fa-bank" => "fa fa-bank",
        "fa fa-bar-chart" => "fa fa-bar-chart",
        "fa fa-bar-chart-o" => "fa fa-bar-chart-o",
        "fa fa-barcode" => "fa fa-barcode",
        "fa fa-bars" => "fa fa-bars",
        "fa fa-bath" => "fa fa-bath",
        "fa fa-bathtub" => "fa fa-bathtub",
        "fa fa-battery" => "fa fa-battery",
        "fa fa-battery-0" => "fa fa-battery-0",
        "fa fa-battery-1" => "fa fa-battery-1",
        "fa fa-battery-2" => "fa fa-battery-2",
        "fa fa-battery-3" => "fa fa-battery-3",
        "fa fa-battery-4" => "fa fa-battery-4",
        "fa fa-battery-empty" => "fa fa-battery-empty",
        "fa fa-battery-full" => "fa fa-battery-full",
        "fa fa-battery-half" => "fa fa-battery-half",
        "fa fa-battery-quarter" => "fa fa-battery-quarter",
        "fa fa-battery-three-quarters" => "fa fa-battery-three-quarters",
        "fa fa-bed" => "fa fa-bed",
        "fa fa-beer" => "fa fa-beer",
        "fa fa-bell" => "fa fa-bell",
        "fa fa-bell-o" => "fa fa-bell-o",
        "fa fa-bell-slash" => "fa fa-bell-slash",
        "fa fa-bell-slash-o" => "fa fa-bell-slash-o",
        "fa fa-bicycle" => "fa fa-bicycle",
        "fa fa-binoculars" => "fa fa-binoculars",
        "fa fa-birthday-cake" => "fa fa-birthday-cake",
        "fa fa-blind" => "fa fa-blind",
        "fa fa-bluetooth" => "fa fa-bluetooth",
        "fa fa-bluetooth-b" => "fa fa-bluetooth-b",
        "fa fa-bolt" => "fa fa-bolt",
        "fa fa-bomb" => "fa fa-bomb",
        "fa fa-book" => "fa fa-book",
        "fa fa-bookmark" => "fa fa-bookmark",
        "fa fa-bookmark-o" => "fa fa-bookmark-o",
        "fa fa-braille" => "fa fa-braille",
        "fa fa-briefcase" => "fa fa-briefcase",
        "fa fa-bug" => "fa fa-bug",
        "fa fa-building" => "fa fa-building",
        "fa fa-building-o" => "fa fa-building-o",
        "fa fa-bullhorn" => "fa fa-bullhorn",
        "fa fa-bullseye" => "fa fa-bullseye",
        "fa fa-bus" => "fa fa-bus",
        "fa fa-cab" => "fa fa-cab",
        "fa fa-calculator" => "fa fa-calculator",
        "fa fa-calendar" => "fa fa-calendar",
        "fa fa-calendar-check-o" => "fa fa-calendar-check-o",
        "fa fa-calendar-minus-o" => "fa fa-calendar-minus-o",
        "fa fa-calendar-o" => "fa fa-calendar-o",
        "fa fa-calendar-plus-o" => "fa fa-calendar-plus-o",
        "fa fa-calendar-times-o" => "fa fa-calendar-times-o",
        "fa fa-camera" => "fa fa-camera",
        "fa fa-camera-retro" => "fa fa-camera-retro",
        "fa fa-car" => "fa fa-car",
        "fa fa-caret-square-o-down" => "fa fa-caret-square-o-down",
        "fa fa-caret-square-o-left" => "fa fa-caret-square-o-left",
        "fa fa-caret-square-o-right" => "fa fa-caret-square-o-right",
        "fa fa-caret-square-o-up" => "fa fa-caret-square-o-up",
        "fa fa-cart-arrow-down" => "fa fa-cart-arrow-down",
        "fa fa-cart-plus" => "fa fa-cart-plus",
        "fa fa-cc" => "fa fa-cc",
        "fa fa-certificate" => "fa fa-certificate",
        "fa fa-check" => "fa fa-check",
        "fa fa-check-circle" => "fa fa-check-circle",
        "fa fa-check-circle-o" => "fa fa-check-circle-o",
        "fa fa-check-square" => "fa fa-check-square",
        "fa fa-check-square-o" => "fa fa-check-square-o",
        "fa fa-child" => "fa fa-child",
        "fa fa-circle" => "fa fa-circle",
        "fa fa-circle-o" => "fa fa-circle-o",
        "fa fa-circle-o-notch" => "fa fa-circle-o-notch",
        "fa fa-circle-thin" => "fa fa-circle-thin",
        "fa fa-clock-o" => "fa fa-clock-o",
        "fa fa-clone" => "fa fa-clone",
        "fa fa-close" => "fa fa-close",
        "fa fa-cloud" => "fa fa-cloud",
        "fa fa-cloud-download" => "fa fa-cloud-download",
        "fa fa-cloud-upload" => "fa fa-cloud-upload",
        "fa fa-code" => "fa fa-code",
        "fa fa-code-fork" => "fa fa-code-fork",
        "fa fa-coffee" => "fa fa-coffee",
        "fa fa-cog" => "fa fa-cog",
        "fa fa-cogs" => "fa fa-cogs",
        "fa fa-comment" => "fa fa-comment",
        "fa fa-comment-o" => "fa fa-comment-o",
        "fa fa-commenting" => "fa fa-commenting",
        "fa fa-commenting-o" => "fa fa-commenting-o",
        "fa fa-comments" => "fa fa-comments",
        "fa fa-comments-o" => "fa fa-comments-o",
        "fa fa-compass" => "fa fa-compass",
        "fa fa-copyright" => "fa fa-copyright",
        "fa fa-creative-commons" => "fa fa-creative-commons",
        "fa fa-credit-card" => "fa fa-credit-card",
        "fa fa-credit-card-alt" => "fa fa-credit-card-alt",
        "fa fa-crop" => "fa fa-crop",
        "fa fa-crosshairs" => "fa fa-crosshairs",
        "fa fa-cube" => "fa fa-cube",
        "fa fa-cubes" => "fa fa-cubes",
        "fa fa-cutlery" => "fa fa-cutlery",
        "fa fa-dashboard" => "fa fa-dashboard",
        "fa fa-database" => "fa fa-database",
        "fa fa-deaf" => "fa fa-deaf",
        "fa fa-deafness" => "fa fa-deafness",
        "fa fa-desktop" => "fa fa-desktop",
        "fa fa-diamond" => "fa fa-diamond",
        "fa fa-dot-circle-o" => "fa fa-dot-circle-o",
        "fa fa-download" => "fa fa-download",
        "fa fa-drivers-license" => "fa fa-drivers-license",
        "fa fa-drivers-license-o" => "fa fa-drivers-license-o",
        "fa fa-edit" => "fa fa-edit",
        "fa fa-ellipsis-h" => "fa fa-ellipsis-h",
        "fa fa-ellipsis-v" => "fa fa-ellipsis-v",
        "fa fa-envelope" => "fa fa-envelope",
        "fa fa-envelope-o" => "fa fa-envelope-o",
        "fa fa-envelope-open" => "fa fa-envelope-open",
        "fa fa-envelope-open-o" => "fa fa-envelope-open-o",
        "fa fa-envelope-square" => "fa fa-envelope-square",
        "fa fa-eraser" => "fa fa-eraser",
        "fa fa-exchange" => "fa fa-exchange",
        "fa fa-exclamation" => "fa fa-exclamation",
        "fa fa-exclamation-circle" => "fa fa-exclamation-circle",
        "fa fa-exclamation-triangle" => "fa fa-exclamation-triangle",
        "fa fa-external-link" => "fa fa-external-link",
        "fa fa-external-link-square" => "fa fa-external-link-square",
        "fa fa-eye" => "fa fa-eye",
        "fa fa-eye-slash" => "fa fa-eye-slash",
        "fa fa-eyedropper" => "fa fa-eyedropper",
        "fa fa-fax" => "fa fa-fax",
        "fa fa-feed" => "fa fa-feed",
        "fa fa-female" => "fa fa-female",
        "fa fa-fighter-jet" => "fa fa-fighter-jet",
        "fa fa-file-archive-o" => "fa fa-file-archive-o",
        "fa fa-file-audio-o" => "fa fa-file-audio-o",
        "fa fa-file-code-o" => "fa fa-file-code-o",
        "fa fa-file-excel-o" => "fa fa-file-excel-o",
        "fa fa-file-image-o" => "fa fa-file-image-o",
        "fa fa-file-movie-o" => "fa fa-file-movie-o",
        "fa fa-file-pdf-o" => "fa fa-file-pdf-o",
        "fa fa-file-photo-o" => "fa fa-file-photo-o",
        "fa fa-file-picture-o" => "fa fa-file-picture-o",
        "fa fa-file-powerpoint-o" => "fa fa-file-powerpoint-o",
        "fa fa-file-sound-o" => "fa fa-file-sound-o",
        "fa fa-file-video-o" => "fa fa-file-video-o",
        "fa fa-file-word-o" => "fa fa-file-word-o",
        "fa fa-file-zip-o" => "fa fa-file-zip-o",
        "fa fa-film" => "fa fa-film",
        "fa fa-filter" => "fa fa-filter",
        "fa fa-fire" => "fa fa-fire",
        "fa fa-fire-extinguisher" => "fa fa-fire-extinguisher",
        "fa fa-flag" => "fa fa-flag",
        "fa fa-flag-checkered" => "fa fa-flag-checkered",
        "fa fa-flag-o" => "fa fa-flag-o",
        "fa fa-flash" => "fa fa-flash",
        "fa fa-flask" => "fa fa-flask",
        "fa fa-folder" => "fa fa-folder",
        "fa fa-folder-o" => "fa fa-folder-o",
        "fa fa-folder-open" => "fa fa-folder-open",
        "fa fa-folder-open-o" => "fa fa-folder-open-o",
        "fa fa-frown-o" => "fa fa-frown-o",
        "fa fa-futbol-o" => "fa fa-futbol-o",
        "fa fa-gamepad" => "fa fa-gamepad",
        "fa fa-gavel" => "fa fa-gavel",
        "fa fa-gear" => "fa fa-gear",
        "fa fa-gears" => "fa fa-gears",
        "fa fa-gift" => "fa fa-gift",
        "fa fa-glass" => "fa fa-glass",
        "fa fa-globe" => "fa fa-globe",
        "fa fa-graduation-cap" => "fa fa-graduation-cap",
        "fa fa-group" => "fa fa-group",
        "fa fa-hand-grab-o" => "fa fa-hand-grab-o",
        "fa fa-hand-lizard-o" => "fa fa-hand-lizard-o",
        "fa fa-hand-paper-o" => "fa fa-hand-paper-o",
        "fa fa-hand-peace-o" => "fa fa-hand-peace-o",
        "fa fa-hand-pointer-o" => "fa fa-hand-pointer-o",
        "fa fa-hand-rock-o" => "fa fa-hand-rock-o",
        "fa fa-hand-scissors-o" => "fa fa-hand-scissors-o",
        "fa fa-hand-spock-o" => "fa fa-hand-spock-o",
        "fa fa-hand-stop-o" => "fa fa-hand-stop-o",
        "fa fa-handshake-o" => "fa fa-handshake-o",
        "fa fa-hard-of-hearing" => "fa fa-hard-of-hearing",
        "fa fa-hashtag" => "fa fa-hashtag",
        "fa fa-hdd-o" => "fa fa-hdd-o",
        "fa fa-headphones" => "fa fa-headphones",
        "fa fa-heart" => "fa fa-heart",
        "fa fa-heart-o" => "fa fa-heart-o",
        "fa fa-heartbeat" => "fa fa-heartbeat",
        "fa fa-history" => "fa fa-history",
        "fa fa-home" => "fa fa-home",
        "fa fa-hotel" => "fa fa-hotel",
        "fa fa-hourglass" => "fa fa-hourglass",
        "fa fa-hourglass-1" => "fa fa-hourglass-1",
        "fa fa-hourglass-2" => "fa fa-hourglass-2",
        "fa fa-hourglass-3" => "fa fa-hourglass-3",
        "fa fa-hourglass-end" => "fa fa-hourglass-end",
        "fa fa-hourglass-half" => "fa fa-hourglass-half",
        "fa fa-hourglass-o" => "fa fa-hourglass-o",
        "fa fa-hourglass-start" => "fa fa-hourglass-start",
        "fa fa-i-cursor" => "fa fa-i-cursor",
        "fa fa-id-badge" => "fa fa-id-badge",
        "fa fa-id-card" => "fa fa-id-card",
        "fa fa-id-card-o" => "fa fa-id-card-o",
        "fa fa-image" => "fa fa-image",
        "fa fa-inbox" => "fa fa-inbox",
        "fa fa-industry" => "fa fa-industry",
        "fa fa-info" => "fa fa-info",
        "fa fa-info-circle" => "fa fa-info-circle",
        "fa fa-institution" => "fa fa-institution",
        "fa fa-key" => "fa fa-key",
        "fa fa-keyboard-o" => "fa fa-keyboard-o",
        "fa fa-language" => "fa fa-language",
        "fa fa-laptop" => "fa fa-laptop",
        "fa fa-leaf" => "fa fa-leaf",
        "fa fa-legal" => "fa fa-legal",
        "fa fa-lemon-o" => "fa fa-lemon-o",
        "fa fa-level-down" => "fa fa-level-down",
        "fa fa-level-up" => "fa fa-level-up",
        "fa fa-life-bouy" => "fa fa-life-bouy",
        "fa fa-life-buoy" => "fa fa-life-buoy",
        "fa fa-life-ring" => "fa fa-life-ring",
        "fa fa-life-saver" => "fa fa-life-saver",
        "fa fa-lightbulb-o" => "fa fa-lightbulb-o",
        "fa fa-line-chart" => "fa fa-line-chart",
        "fa fa-location-arrow" => "fa fa-location-arrow",
        "fa fa-lock" => "fa fa-lock",
        "fa fa-low-vision" => "fa fa-low-vision",
        "fa fa-magic" => "fa fa-magic",
        "fa fa-magnet" => "fa fa-magnet",
        "fa fa-mail-forward" => "fa fa-mail-forward",
        "fa fa-mail-reply" => "fa fa-mail-reply",
        "fa fa-mail-reply-all" => "fa fa-mail-reply-all",
        "fa fa-male" => "fa fa-male",
        "fa fa-map" => "fa fa-map",
        "fa fa-map-marker" => "fa fa-map-marker",
        "fa fa-map-o" => "fa fa-map-o",
        "fa fa-map-pin" => "fa fa-map-pin",
        "fa fa-map-signs" => "fa fa-map-signs",
        "fa fa-meh-o" => "fa fa-meh-o",
        "fa fa-microchip" => "fa fa-microchip",
        "fa fa-microphone" => "fa fa-microphone",
        "fa fa-microphone-slash" => "fa fa-microphone-slash",
        "fa fa-minus" => "fa fa-minus",
        "fa fa-minus-circle" => "fa fa-minus-circle",
        "fa fa-minus-square" => "fa fa-minus-square",
        "fa fa-minus-square-o" => "fa fa-minus-square-o",
        "fa fa-mobile" => "fa fa-mobile",
        "fa fa-mobile-phone" => "fa fa-mobile-phone",
        "fa fa-money" => "fa fa-money",
        "fa fa-moon-o" => "fa fa-moon-o",
        "fa fa-mortar-board" => "fa fa-mortar-board",
        "fa fa-motorcycle" => "fa fa-motorcycle",
        "fa fa-mouse-pointer" => "fa fa-mouse-pointer",
        "fa fa-music" => "fa fa-music",
        "fa fa-navicon" => "fa fa-navicon",
        "fa fa-newspaper-o" => "fa fa-newspaper-o",
        "fa fa-object-group" => "fa fa-object-group",
        "fa fa-object-ungroup" => "fa fa-object-ungroup",
        "fa fa-paint-brush" => "fa fa-paint-brush",
        "fa fa-paper-plane" => "fa fa-paper-plane",
        "fa fa-paper-plane-o" => "fa fa-paper-plane-o",
        "fa fa-paw" => "fa fa-paw",
        "fa fa-pencil" => "fa fa-pencil",
        "fa fa-pencil-square" => "fa fa-pencil-square",
        "fa fa-pencil-square-o" => "fa fa-pencil-square-o",
        "fa fa-percent" => "fa fa-percent",
        "fa fa-phone" => "fa fa-phone",
        "fa fa-phone-square" => "fa fa-phone-square",
        "fa fa-photo" => "fa fa-photo",
        "fa fa-picture-o" => "fa fa-picture-o",
        "fa fa-pie-chart" => "fa fa-pie-chart",
        "fa fa-plane" => "fa fa-plane",
        "fa fa-plug" => "fa fa-plug",
        "fa fa-plus" => "fa fa-plus",
        "fa fa-plus-circle" => "fa fa-plus-circle",
        "fa fa-plus-square" => "fa fa-plus-square",
        "fa fa-plus-square-o" => "fa fa-plus-square-o",
        "fa fa-podcast" => "fa fa-podcast",
        "fa fa-power-off" => "fa fa-power-off",
        "fa fa-print" => "fa fa-print",
        "fa fa-puzzle-piece" => "fa fa-puzzle-piece",
        "fa fa-qrcode" => "fa fa-qrcode",
        "fa fa-question" => "fa fa-question",
        "fa fa-question-circle" => "fa fa-question-circle",
        "fa fa-question-circle-o" => "fa fa-question-circle-o",
        "fa fa-quote-left" => "fa fa-quote-left",
        "fa fa-quote-right" => "fa fa-quote-right",
        "fa fa-random" => "fa fa-random",
        "fa fa-recycle" => "fa fa-recycle",
        "fa fa-refresh" => "fa fa-refresh",
        "fa fa-registered" => "fa fa-registered",
        "fa fa-remove" => "fa fa-remove",
        "fa fa-reorder" => "fa fa-reorder",
        "fa fa-reply" => "fa fa-reply",
        "fa fa-reply-all" => "fa fa-reply-all",
        "fa fa-retweet" => "fa fa-retweet",
        "fa fa-road" => "fa fa-road",
        "fa fa-rocket" => "fa fa-rocket",
        "fa fa-rss" => "fa fa-rss",
        "fa fa-rss-square" => "fa fa-rss-square",
        "fa fa-s15" => "fa fa-s15",
        "fa fa-search" => "fa fa-search",
        "fa fa-search-minus" => "fa fa-search-minus",
        "fa fa-search-plus" => "fa fa-search-plus",
        "fa fa-send" => "fa fa-send",
        "fa fa-send-o" => "fa fa-send-o",
        "fa fa-server" => "fa fa-server",
        "fa fa-share" => "fa fa-share",
        "fa fa-share-alt" => "fa fa-share-alt",
        "fa fa-share-alt-square" => "fa fa-share-alt-square",
        "fa fa-share-square" => "fa fa-share-square",
        "fa fa-share-square-o" => "fa fa-share-square-o",
        "fa fa-shield" => "fa fa-shield",
        "fa fa-ship" => "fa fa-ship",
        "fa fa-shopping-bag" => "fa fa-shopping-bag",
        "fa fa-shopping-basket" => "fa fa-shopping-basket",
        "fa fa-shopping-cart" => "fa fa-shopping-cart",
        "fa fa-shower" => "fa fa-shower",
        "fa fa-sign-in" => "fa fa-sign-in",
        "fa fa-sign-language" => "fa fa-sign-language",
        "fa fa-sign-out" => "fa fa-sign-out",
        "fa fa-signal" => "fa fa-signal",
        "fa fa-signing" => "fa fa-signing",
        "fa fa-sitemap" => "fa fa-sitemap",
        "fa fa-sliders" => "fa fa-sliders",
        "fa fa-smile-o" => "fa fa-smile-o",
        "fa fa-snowflake-o" => "fa fa-snowflake-o",
        "fa fa-soccer-ball-o" => "fa fa-soccer-ball-o",
        "fa fa-sort" => "fa fa-sort",
        "fa fa-sort-alpha-asc" => "fa fa-sort-alpha-asc",
        "fa fa-sort-alpha-desc" => "fa fa-sort-alpha-desc",
        "fa fa-sort-amount-asc" => "fa fa-sort-amount-asc",
        "fa fa-sort-amount-desc" => "fa fa-sort-amount-desc",
        "fa fa-sort-asc" => "fa fa-sort-asc",
        "fa fa-sort-desc" => "fa fa-sort-desc",
        "fa fa-sort-down" => "fa fa-sort-down",
        "fa fa-sort-numeric-asc" => "fa fa-sort-numeric-asc",
        "fa fa-sort-numeric-desc" => "fa fa-sort-numeric-desc",
        "fa fa-sort-up" => "fa fa-sort-up",
        "fa fa-space-shuttle" => "fa fa-space-shuttle",
        "fa fa-spinner" => "fa fa-spinner",
        "fa fa-spoon" => "fa fa-spoon",
        "fa fa-square" => "fa fa-square",
        "fa fa-square-o" => "fa fa-square-o",
        "fa fa-star" => "fa fa-star",
        "fa fa-star-half" => "fa fa-star-half",
        "fa fa-star-half-empty" => "fa fa-star-half-empty",
        "fa fa-star-half-full" => "fa fa-star-half-full",
        "fa fa-star-half-o" => "fa fa-star-half-o",
        "fa fa-star-o" => "fa fa-star-o",
        "fa fa-sticky-note" => "fa fa-sticky-note",
        "fa fa-sticky-note-o" => "fa fa-sticky-note-o",
        "fa fa-street-view" => "fa fa-street-view",
        "fa fa-suitcase" => "fa fa-suitcase",
        "fa fa-sun-o" => "fa fa-sun-o",
        "fa fa-support" => "fa fa-support",
        "fa fa-tablet" => "fa fa-tablet",
        "fa fa-tachometer" => "fa fa-tachometer",
        "fa fa-tag" => "fa fa-tag",
        "fa fa-tags" => "fa fa-tags",
        "fa fa-tasks" => "fa fa-tasks",
        "fa fa-taxi" => "fa fa-taxi",
        "fa fa-television" => "fa fa-television",
        "fa fa-terminal" => "fa fa-terminal",
        "fa fa-thermometer" => "fa fa-thermometer",
        "fa fa-thermometer-0" => "fa fa-thermometer-0",
        "fa fa-thermometer-1" => "fa fa-thermometer-1",
        "fa fa-thermometer-2" => "fa fa-thermometer-2",
        "fa fa-thermometer-3" => "fa fa-thermometer-3",
        "fa fa-thermometer-4" => "fa fa-thermometer-4",
        "fa fa-thermometer-empty" => "fa fa-thermometer-empty",
        "fa fa-thermometer-full" => "fa fa-thermometer-full",
        "fa fa-thermometer-half" => "fa fa-thermometer-half",
        "fa fa-thermometer-quarter" => "fa fa-thermometer-quarter",
        "fa fa-thermometer-three-quarters" => "fa fa-thermometer-three-quarters",
        "fa fa-thumb-tack" => "fa fa-thumb-tack",
        "fa fa-thumbs-down" => "fa fa-thumbs-down",
        "fa fa-thumbs-o-down" => "fa fa-thumbs-o-down",
        "fa fa-thumbs-o-up" => "fa fa-thumbs-o-up",
        "fa fa-thumbs-up" => "fa fa-thumbs-up",
        "fa fa-ticket" => "fa fa-ticket",
        "fa fa-times" => "fa fa-times",
        "fa fa-times-circle" => "fa fa-times-circle",
        "fa fa-times-circle-o" => "fa fa-times-circle-o",
        "fa fa-times-rectangle" => "fa fa-times-rectangle",
        "fa fa-times-rectangle-o" => "fa fa-times-rectangle-o",
        "fa fa-tint" => "fa fa-tint",
        "fa fa-toggle-down" => "fa fa-toggle-down",
        "fa fa-toggle-left" => "fa fa-toggle-left",
        "fa fa-toggle-off" => "fa fa-toggle-off",
        "fa fa-toggle-on" => "fa fa-toggle-on",
        "fa fa-toggle-right" => "fa fa-toggle-right",
        "fa fa-toggle-up" => "fa fa-toggle-up",
        "fa fa-trademark" => "fa fa-trademark",
        "fa fa-trash" => "fa fa-trash",
        "fa fa-trash-o" => "fa fa-trash-o",
        "fa fa-tree" => "fa fa-tree",
        "fa fa-trophy" => "fa fa-trophy",
        "fa fa-truck" => "fa fa-truck",
        "fa fa-tty" => "fa fa-tty",
        "fa fa-tv" => "fa fa-tv",
        "fa fa-umbrella" => "fa fa-umbrella",
        "fa fa-universal-access" => "fa fa-universal-access",
        "fa fa-university" => "fa fa-university",
        "fa fa-unlock" => "fa fa-unlock",
        "fa fa-unlock-alt" => "fa fa-unlock-alt",
        "fa fa-unsorted" => "fa fa-unsorted",
        "fa fa-upload" => "fa fa-upload",
        "fa fa-user" => "fa fa-user",
        "fa fa-user-circle" => "fa fa-user-circle",
        "fa fa-user-circle-o" => "fa fa-user-circle-o",
        "fa fa-user-o" => "fa fa-user-o",
        "fa fa-user-plus" => "fa fa-user-plus",
        "fa fa-user-secret" => "fa fa-user-secret",
        "fa fa-user-times" => "fa fa-user-times",
        "fa fa-users" => "fa fa-users",
        "fa fa-vcard" => "fa fa-vcard",
        "fa fa-vcard-o" => "fa fa-vcard-o",
        "fa fa-video-camera" => "fa fa-video-camera",
        "fa fa-volume-control-phone" => "fa fa-volume-control-phone",
        "fa fa-volume-down" => "fa fa-volume-down",
        "fa fa-volume-off" => "fa fa-volume-off",
        "fa fa-volume-up" => "fa fa-volume-up",
        "fa fa-warning" => "fa fa-warning",
        "fa fa-wheelchair" => "fa fa-wheelchair",
        "fa fa-wheelchair-alt" => "fa fa-wheelchair-alt",
        "fa fa-wifi" => "fa fa-wifi",
        "fa fa-window-close" => "fa fa-window-close",
        "fa fa-window-close-o" => "fa fa-window-close-o",
        "fa fa-window-maximize" => "fa fa-window-maximize",
        "fa fa-window-minimize" => "fa fa-window-minimize",
        "fa fa-window-restore" => "fa fa-window-restore",
        "fa fa-wrench" => "fa fa-wrenc>"
    );

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscar(Request $request)
    {
        $pagina           = $request->input('page');
        $filas            = $request->input('filas');
        $entidad          = 'Menuoptioncategory';
        $name             = Libreria::getParam($request->input('name'));
        $resultado        = Menuoptioncategory::listar($name);
        $lista            = $resultado->get();
        $cabecera         = array();
        $cabecera[]       = array('valor' => '#', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Nombre', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Icono', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Orden', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Categoría', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Posición', 'numero' => '1');
        $cabecera[]       = array('valor' => 'Acciones', 'numero' => '2');
        
        $titulo_modificar = $this->tituloModificar;
        $titulo_eliminar  = $this->tituloEliminar;
        $ruta             = $this->rutas;
        if (count($lista) > 0) {
            $clsLibreria     = new Libreria();
            $paramPaginacion = $clsLibreria->generarPaginacion($lista, $pagina, $filas, $entidad);
            $paginacion      = $paramPaginacion['cadenapaginacion'];
            $inicio          = $paramPaginacion['inicio'];
            $fin             = $paramPaginacion['fin'];
            $paginaactual    = $paramPaginacion['nuevapagina'];
            $lista           = $resultado->paginate($filas);
            $request->replace(array('page' => $paginaactual));
            return view($this->folderview.'.list')->with(compact('lista', 'paginacion', 'inicio', 'fin', 'entidad', 'cabecera', 'titulo_modificar', 'titulo_eliminar', 'ruta'));
        }
        return view($this->folderview.'.list')->with(compact('lista', 'entidad'));
    }

    public function index()
    {
        $entidad          = 'Menuoptioncategory';
        $title            = $this->tituloAdmin;
        $titulo_registrar = $this->tituloRegistrar;
        $ruta             = $this->rutas;
        return view($this->folderview.'.admin')->with(compact('entidad', 'title', 'titulo_registrar', 'ruta'));
    }

    public function create(Request $request)
    {
        $listar              = Libreria::getParam($request->input('listar'), 'NO');
        $entidad             = 'Menuoptioncategory';
        $cboCategoria        = [''=>'-- Seleccione una categoría --'] + Menuoptioncategory::pluck('name', 'id')->all();
        $menuoptioncategory = null;
        $cboPosition         = array('V'=>'Vertical','H' => 'Horizontal');
        $formData            = array('menuoptioncategory.store');
        $formData            = array('route' => $formData, 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton               = 'Registrar';
        $cboIconos           = $this->cboIconos;
        return view($this->folderview.'.mant')->with(compact('menuoptioncategory', 'formData', 'entidad', 'boton', 'cboCategoria', 'listar','cboPosition', 'cboIconos'));
    }

    public function store(Request $request)
    {
        $listar     = Libreria::getParam($request->input('listar'), 'NO');
        $validacion = Validator::make($request->all(),
            array(
                'name'                  => 'required|max:60',
                'menuoptioncategory_id' => 'nullable|integer|exists:menuoptioncategory,id,deleted_at,NULL',
                'order'                 => 'required|integer',
                'icon'                  => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        }
        $error = DB::transaction(function() use($request){
            $menuoptioncategory                        = new Menuoptioncategory();
            $menuoptioncategory->name                  = $request->input('name');
            $menuoptioncategory->order                 = $request->input('order');
            $menuoptioncategory->icon                  = $request->input('icon');
            $menuoptioncategory->position                  = $request->input('position');
            $menuoptioncategory->menuoptioncategory_id = Libreria::obtenerParametro($request->input('menuoptioncategory_id'));
            $menuoptioncategory->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se CREA la Categoría de Opción de Menú ' . $request->input('name');
            $bitacora->tabla = 'CATEGORÍA DE OPCIÓN DE MENÚ';
            $bitacora->tabla_id = $menuoptioncategory->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function show($id)
    {
        //
    }

    public function edit($id, Request $request)
    {
        $existe = Libreria::verificarExistencia($id, 'menuoptioncategory');
        if ($existe !== true) {
            return $existe;
        }
        $listar              = Libreria::getParam($request->input('listar'), 'NO');
        $menuoptioncategory = Menuoptioncategory::find($id);
        $entidad             = 'Menuoptioncategory';
        $cboCategoria        = [''=>'-- Seleccione una categoría --'] + Menuoptioncategory::where('id', '<>', $id)->pluck('name', 'id')->all();
        $cboPosition         = array('V'=>'Vertical','H' => 'Horizontal');
        $formData            = array('menuoptioncategory.update', $id);
        $formData            = array('route' => $formData, 'method' => 'PUT', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton               = 'Modificar';
        $cboIconos           = $this->cboIconos;
        return view($this->folderview.'.mant')->with(compact('menuoptioncategory', 'formData', 'entidad', 'boton', 'cboCategoria', 'listar','cboPosition', 'cboIconos'));        
    }

    public function update(Request $request, $id)
    {
        $existe = Libreria::verificarExistencia($id, 'menuoptioncategory');
        if ($existe !== true) {
            return $existe;
        }
        $validacion = Validator::make($request->all(),
            array(
                'name'                  => 'required|max:60',
                'menuoptioncategory_id' => 'nullable|integer|exists:menuoptioncategory,id,deleted_at,NULL',
                'order'                 => 'required|integer',
                'icon'                  => 'required'
                )
            );
        if ($validacion->fails()) {
            return $validacion->messages()->toJson();
        } 
        $error = DB::transaction(function() use($request, $id){
            $menuoptioncategory                        = Menuoptioncategory::find($id);
            $menuoptioncategory->name                  = $request->input('name');
            $menuoptioncategory->order                 = $request->input('order');
            $menuoptioncategory->icon                  = $request->input('icon');
            $menuoptioncategory->position                  = $request->input('position');
            $menuoptioncategory->menuoptioncategory_id = Libreria::obtenerParametro($request->input('menuoptioncategory_id')); 
            $menuoptioncategory->save();

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se MODIFICA la Categoría de Opción de Menú ' . $request->input('name');
            $bitacora->tabla = 'CATEGORÍA DE OPCIÓN DE MENÚ';
            $bitacora->tabla_id = $menuoptioncategory->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();
        });
        return is_null($error) ? "OK" : $error;
    }

    public function destroy($id)
    {
        $existe = Libreria::verificarExistencia($id, 'menuoptioncategory');
        if ($existe !== true) {
            return $existe;
        }
        $error = DB::transaction(function() use($id){
            $menuoptioncategory = Menuoptioncategory::find($id);

            $user     = Auth::user();
            $bitacora = new Bitacora();
            $bitacora->fecha = date('Y-m-d');
            $bitacora->descripcion = 'Se ELIMINA la Categoría de Opción de menú ' . $menuoptioncategory->name;
            $bitacora->tabla = 'CATEGORÍA DE OPCIÓN DE MENÚ';
            $bitacora->tabla_id = $menuoptioncategory->id;
            $bitacora->usuario_id = $user->id;
            $bitacora->save();

            $menuoptioncategory->delete();
        });
        return is_null($error) ? "OK" : $error;
    }
    
    public function eliminar($id, $listarLuego)
    {
        $existe = Libreria::verificarExistencia($id, 'menuoptioncategory');
        if ($existe !== true) {
            return $existe;
        }
        $listar = "NO";
        if (!is_null(Libreria::obtenerParametro($listarLuego))) {
            $listar = $listarLuego;
        }
        $modelo   = Menuoptioncategory::find($id);
        $mensaje = '<p class="text-inverse">¿Esta seguro de eliminar el registro "'.$modelo->name.'"?</p>';
        $entidad  = 'Menuoptioncategory';
        $formData = array('route' => array('menuoptioncategory.destroy', $id), 'method' => 'DELETE', 'class' => 'form-horizontal', 'id' => 'formMantenimiento'.$entidad, 'autocomplete' => 'off');
        $boton    = 'Eliminar';        
        return view('app.confirmarEliminar')->with(compact('modelo', 'formData', 'entidad', 'boton', 'listar','mensaje'));
    }
}