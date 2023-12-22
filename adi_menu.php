<?php

// NOTE

/*
    adi_menu - Section hierarchy, section menu and breadcrumb trail

    Written by Adi Gilbert

    Released under the GNU General Public License

    Version history:
    1.5     - TXP 4.7+ only
            - attributes removed: 'test', 'new_article_mode', 'sep'
            - new: link names shown in redirect link select list
            - new: attributes 'parent_link_class', 'sub_menu_class' & 'sub_menu_link_class' (for demoncleaner)
            - new: admin tab paging (for wavesource, kees-b, Bruce Bowden and me)
            - improvement: admin tab style tweaks
            - fix: pageless sections ignored (4.8+)
            - fix: title_no_widow error in articles mode (4.8+)
            - fix: db table settings tweaks (thanks Bruce Bowden)
            - fix: admin tab section list fiddling plays nicely with bot_wtc (thanks demoncleaner)
    1.4.2   - include textpacks within plugin; remove remote install facility
            - remove unneeded options panel
            - TXP 4.6+ only
    1.4.1   - new: relative_urls attribute: link URLs without domain name and http(s) prefix (for demoncleaner)
            - fix: uncaught type error in PHP 8.2
    1.4     - new feature: virtual sections
            - new categories features:
                - redirect to Article category option
                - categoried articles in menu
                - new attributes 'cat_article_include', 'cat_article_exclude', 'cat_article_sort', 'cat_article_attr'
            - new admin feature: drag & drop section ordering
            - new classes 'menu_virtual', 'menu_category', 'menu_clone'
            - new attribute 'ignore_alt_title' for adi_menu & adi_breadcrumb tags
            - new attributes 'exclude_clone', 'role' **, 'override_exclude' & suppress_url_sections for adi_menu tag
            - new attribute 'labeltag' for adi_breadcrumb
            - new attributes 'force_current' & 'current_descendants_only' (for detail)
            - new tags: adi_menu_info & adi_menu_if_info
            - fix: stop clone inheriting an alternative title
            - fix: adi_breadcrumb now uses alternative title
            - fix: article list defaults to live only (use status="" for both live & sticky) **
            - fix: active class applied to menu items that are redirected to active section **
            - fix: disallow sections to be selected as parents of, or redirect to, themselves
            - fix: disabled submenus on error pages
            - fix: breadcrumb less crummy on error pages
            - fix: prevent empty HTML class attribute when adi_breadcrumb 'linkclass' is empty (thanks CeBe)
            - fix: table prefix issue (thanks sochicomputerRU)
            - deprecated attributes: 'clone_title', 'test', 'new_article_mode' **
            - deprecated "old article mode" **
            - now updates lastmod
            - TXP 4.5+ only
            - updated for TXP 4.6
    beta13  - removed versions output from debug
            - fix: blank adi_menu_redirect_link now set to default (0) not ''
            - fixed dodgy 4.6 fix: restored greyness to menu key item
            ** upgrade considerations - beta users visit Admin tab after install
    beta14  - fix: memory limit exceeded error with numeric section names (thanks kees-b & Bruce Bowden)
    1.3.1   - lifecycle "upgrade" pseudo-event
            - fixed links to section tab in TXP 4.5
    1.3     - TXP 4.5-ified
            - moved install/uninstall to plugin options
            - Textpack added
            - tooltips thrown in the tip
            - fix: preferences fully deleted on uninstall
            - enhancement: adi_menu admin section redirect warning message
            - enhancement: admin preference "Prevent widowed words in article titles" now obeyed (for springworks)
            - code tidy up & old code removed
            - change: removed import functionality
            - change: admin tab name changed "adi_menu" -> "Menu"
            - change: use pluggable_ui instead of old inject method in Article tab
    1.2     - section-specific article sort (for bg)
            - enhancement: adi_menu admin sections link to TXP section tab
            - fix: ampersands in article titles (thanks renobird)
            - fix: admin styling for Hive
            - now uses lifecycle events for install/uninstall
    1.1.1   - fixed: one adi_menu tag affecting operation of another (thanks Teemu)
            - fix: renamed some globals
            - fix: restrict style to adi_menu_admin tab only
    1.1     - enhancement: section redirection (for me & caruso_g)
            - enhancement: alternative section titles
            - enhancement: adi_menu admin tab now only shows admin options (i.e. install/uninstall/import) if relevant
            - enhancement: admin tab sanity checks - sections renamed or links deleted
            - enhancement: write tab section popup list format & indent preferences (for Bloke)
            - enhancement: new article method, attribute 'new_article_mode' to switch off ('test' attribute ignored)
            - new attribute: 'odd_even' to generate <li> classes on odd/even items
            - change: section sort now defaults to "adi_menu_sort" (use sort="" to override)
            - fix: dodgy bold in hierarchy summary, added italics & "default" now "Home"
            - fix: errors in admin tab if sections renamed
            - fix: submenus not being generated properly (again)
    1.0     - testing only, not officially released
    0.12.   - fix: error on error page when sub_menu_level > 1 (thanks CeBe)
            - fix: error with submenu if active section excluded in admin
    0.12    - new attribute 'current_children_only' (for ttr & caruso_g)
            - enhancement: new (automatic) way of coping with accented characters (thanks ttr)
            - enhancement: minor admin tab improvements - admin options (i.e. install/uninstall/import) only shown if relevant
            - fix: error when adi_menu_breadcrumb used more than once on a page (thanks jcd)
            - fix: current_children_only not functioning correctly (thanks jcd)
            - fix: couple of uninitialised variables generating error_log messages (lines 827, 837)
    0.11    - new adi_menu attributes: 'wraptag', 'wraptag_id', 'wraptag_class'
            - enhancement: sections attribute now overrides admin excluded sections
    0.10    - enhancement: speaking blocks
            - new adi_menu attributes: 'speaking_block' & 'speaking_block_form'
            - new adi_menu attributes: 'label', 'labeltag', 'label_class', 'label_id'
            - fix: empty <ul></ul> output for section-less submenus
    0.9.2   - fix: static sections (sed_section_fields) visible to non-Publisher users in Write tab (thanks Didjee)
            - fix: sections with clones wrongly indented in Write tab section popup
    0.9.1   - fix: accented characters getting escaped in admin (for jpdupont)
            - enhancement: new 'escape' attribute option: htmlspecial
    0.9     - new adi_menu attribute: 'sub_menu_level' (for emerald)
            - fix: selected section in Write tab changes to first section in list after saving new article
    0.8.1   - fix: submenus not being generated properly
            - fix: suppressed output of 'id=""' & 'class=""' in top level <ul> when menu_id="" & class=""
    0.8     - enhancement: section hierarchy in Write tab section popup
            - new adi_menu attributes: 'first_class' & 'last_class' (for renobird)
            - new adi_menu attributes: 'list_prefix' & 'prefix_class' (for nubian)
            - new adi_menu attribute: suppress_url (for renobird)
            - enhancement: adi_menu & adi_menu_breadcrumb tags now output error message if adi_menu not installed
            - fix: MySQL v4 errors in adi_menu admin (for debegray)
                - used 'TINYINT(1) DEFAULT 0' instead of 'BOOLEAN DEFAULT FALSE'
                - where clause '1=1' instead of 'TRUE'
            - fix: loop detection failure with A->B->C->B sub-loops
            - optimisation: removed section_list['name'] & $hierarchy['name'] array elements
            - articles enhancement (beta) new attributes: 'article_class', 'article_position', 'article_sort'
    0.7     - new adi_menu & adi_menu_breadcrumb attribute: 'escape'
            - new adi_menu attribute: 'active_ancestors' (for Didjee)
            - fix: adi_menu admin hierarchy summary now shows children again
            - fix: no longer get double row of admin page tabs before adi_menu installed
    0.6     - enhancement: article capability added
            - new adi_menu attributes: 'articles', 'article_attr', 'article_include', 'article_exclude'
            - new adi_menu attributes: 'include_children', 'include_current' & 'active_parent' (for macTigers)
            - new adi_menu attribute: 'active_articles_only' (for FireFusion)
            - new adi_menu attribute: 'list_span' (sIFR support, for Lasse Gyrn)
            - code optimisations (thanks to net-carver)
    0.5     - fix: adi_menu errors if 'default' section excluded (thanks Uli)
            - fix: adi_menu tab section hierarchy would generate lots of errors if adi_menu not installed
            - enhancement: sections attribute functionality improved (for Si & freischwimmen)
                - children now output automatically
                - new tags 'include_parent' & 'include_childless'
    0.4     - enhancement: adi_breadcrumb tag attribute 'link_last' - last section crumb in list displayed in plain text (now the default behaviour)
            - fix: adi_menu_breadcrumb error when visiting sections/pages that don't exist when in clean URL mode
            - fix: adi_menu_breadcrumb displayed default section as link regardless of 'link' attribute setting
    0.3     - enhancement: new adi_menu tag attribute 'link_span' - wrap <span>...</span> around contents of links
            - enhancement: new adi_menu tag attributes 'list_id' & 'list_id_prefix' - output unique IDs to <li> elements
            - enhancement: new adi_menu tag attribute 'active_li_class' - output class on active <li>
            - enhancement: adi_menu admin now displays summary of configured section hierarchy
            - modification: adi_breadcrumb tag attribute 'sep' deprecated for 'separator'
    0.2     - fix: adi_menu_breadcrumb error when visiting pages that are excluded in adi_menu admin
            - fix: adi_menu_breadcrumb now copes with section loops, error message output
            - fix: adi_menu tag can now be used more than once on a page
            - enhancement: adi_menu admin section loop warning message
            - enhancement: adi_menu admin now displays sections in alphabetical order
    0.1     - initial release

    DOWNGRADE (from 1.4 to 1.1+ only)
    - go to adi_menu plugin options tab
    - add "&step=downgrade" to end of URL & hit return
    - then immediately install previous version of adi_menu

*/

/* TODO

    - deprecate old submenu method (probably just need to stop talking about it)
    - demoncleaner's enhancements

*/

/* SECTION NAMING
    - sections can be named as numbers (e.g. 1, 2020 etc)
    - TXP admin won't allow creation of section "0"
    - section name used as index in various arrays: $section_list, $hierarchy, $section_levels
        - numeric section indexes converted to numeric key by PHP
        - use of array_merge() will result in keys being renumbered (starting at 0, which then results in recursive bottomless pits)

*/

// TXP 4.6 tag registration
if (class_exists('\Textpattern\Tag\Registry')) {
    Txp::get('\Textpattern\Tag\Registry')
        ->register('adi_menu')
        ->register('adi_menu_breadcrumb')
        ->register('adi_menu_info')
        ->register('adi_menu_if_info')
    ;
}

// variables used by both admin tab AND public side
global $adi_menu_debug, $adi_menu_db_debug, $adi_menu_article_form, $adi_menu_sql_fields, $adi_menu_vs_sql_fields, $adi_menu_vs_prefix, $adi_menu_info_types;

$adi_menu_debug = 0; // display admin debug info
$adi_menu_db_debug = 0; // display database debug info

$adi_menu_article_form = 'adi_menu_articles'; //  for old article mode

$adi_menu_vs_prefix = 'v_'; // prefix for virtual sections (used in parent field and in markup)

// DB fields              txp_section                   adi_menu
//    section name        name                          name
//    section title       title                         title
//    parent section      adi_menu_parent               parent
//    alternative title   adi_menu_alt_title            alt_title
//    cloned?             adi_menu_clone                clone
//    clone title         adi_menu_title                clone_title
//    section redirect    adi_menu_redirect_section     section
//    link redirect       adi_menu_redirect_link        link
//    category redirect   adi_menu_redirect_category    category
//    sort                adi_menu_sort                 sort

$adi_menu_sql_fields = 'name, title, adi_menu_parent, adi_menu_title, adi_menu_exclude, adi_menu_clone, adi_menu_sort, adi_menu_redirect_section, adi_menu_redirect_link, adi_menu_redirect_category, adi_menu_alt_title';

$adi_menu_vs_sql_fields = 'id as adi_menu_id, name, title, parent as adi_menu_parent, exclude as adi_menu_exclude, sort as adi_menu_sort, section as adi_menu_redirect_section, link as adi_menu_redirect_link, category as adi_menu_redirect_category, alt_title as adi_menu_alt_title, clone as adi_menu_clone, clone_title as adi_menu_title';

// menu info type to DB column mapping - used by <txp:adi_menu_info /> & <txp:adi_menu_if_info /> tags
$adi_menu_info_types =
    array(
    // indexed by user-supplied "type": 'column' => DB column(s) to reference, 'blank' => what constitutes a blank/empty/not-set value (column lists only used by <txp:adi_menu_if_info /> - TRUE if any not blank)
        // directly mapped
        'parent'             => array('column' => 'adi_menu_parent', 'blank' => ''),
        'title'              => array('column' => 'title', 'blank' => ''),
        'alt_title'          => array('column' => 'adi_menu_alt_title', 'blank' => ''),
        'exclude'            => array('column' => 'adi_menu_exclude', 'blank' => '0'), // boolean
        'clone'              => array('column' => 'adi_menu_clone', 'blank' => '0'), // boolean
        'clone_title'        => array('column' => 'adi_menu_title', 'blank' => ''),
        'redirect_section'   => array('column' => 'adi_menu_redirect_section', 'blank' => ''),
        'redirect_link'      => array('column' => 'adi_menu_redirect_link', 'blank' => '0'), // column DEFAULT is zero
        'redirect_category'  => array('column' => 'adi_menu_redirect_category', 'blank' => ''),
        // special types
        'redirect'           => array('column' => 'adi_menu_redirect_section,adi_menu_redirect_link,adi_menu_redirect_category', 'blank' => ''), // column list: TRUE if any not blank
        'menu_title'         => array('column' => 'title', 'blank' => ''), // "deduced" information, based on alternative title availability & ignore_alt_title attribute
        'ancestors'          => array('column' => 'adi_menu_parent', 'blank' => '') // find ancestors, starting with parent
    );

if (txpinterface === 'admin') {
    // it's a modern-ish world
    if (!version_compare(txp_version, '4.7.0', '>=')) return;

    adi_menu_init();
}

function adi_menu_init() {
// general admin setup
    global $prefs, $event, $adi_menu_prefs, $adi_menu_debug, $adi_menu_db_debug;

    $adi_menu_installed = adi_menu_installed();

    // plugin lifecycle
    register_callback('adi_menu_lifecycle', 'plugin_lifecycle.adi_menu');

    // set the privilege levels
    add_privs('adi_menu_admin', '1,2,3,6');

    // default plugin preference settings
    $adi_menu_prefs = array(
        'write_tab_select_indent'    => '0', // or 0
        'write_tab_select_format'    => 'name', // or 'title'
        'write_tab_select_default'   => '0', // or not
        'admin_pageby'               => 12,
    );

    // adi_menu admin tab under 'Presentation'
    if ($adi_menu_installed) {
        register_tab('presentation', 'adi_menu_admin', gtxt('adi_menu'));
        register_callback('adi_menu_admin', 'adi_menu_admin');
        if ((adi_menu_prefs('write_tab_select_format') != 'name') || adi_menu_prefs('write_tab_select_indent'))
            register_callback('adi_menu_section_titles', 'article_ui', 'section');
    }

    // style
    if ($event == 'adi_menu_admin')
        register_callback('adi_menu_style', 'admin_side', 'head_end');

    // script
    if ($event == 'adi_menu_admin')
        register_callback('adi_menu_admin_script', 'admin_side', 'head_end');
}

function adi_menu_admin_script() {
// jQuery magic for admin tab

    $section_list = adi_menu_section_list('', '', TRUE);
    $sort_value_jquery = '';
    foreach ($section_list as $name => $section) {
        $sort_value_jquery .= '$("#mainmenu li#'.$name.' > input").attr("value","'.$section['adi_menu_sort'].'");'.n;
        if ($section['adi_menu_exclude'])
            $sort_value_jquery .= '$("#mainmenu li#'.$name.'").addClass("adi_menu_excluded");'.n;
    }

    $button_text = gTxt('adi_menu_update_order');

    $ui_script = '';

    echo <<<END_SCRIPT
<!-- drag and drop -->
$ui_script
<script>
    // adi_menu
    $(function() {
        $('form.adi_menu_form #list .adi_menu_sort').hide(); // hide sort value column
        $('#adi_menu_summary').addClass('adi_menu_drag_drop');

        $("#mainmenu").wrap('<form class="adi_menu_summary" action="index.php#adi_menu_summary" method="post"></form>');
        $("#mainmenu li").each(function(){
            var this_id = $(this).attr('id');
            $(this).append('<input type="hidden" value="" class="sort_value" />');
            $('input',this).attr('name','sort['+this_id+']');
        });
        $("#mainmenu li.menu_virtual").each(function(){
            var this_id = $(this).attr('id');
            $(this).children('input').attr('name','virtual_sort['+this_id+']'); // immediate children
        });

        $sort_value_jquery

        $("form.adi_menu_summary").append('<input type="hidden" name="event" value="adi_menu_admin" />');
        $("form.adi_menu_summary").append('<input type="hidden" name="step" value="sort_update" />');
        $("form.adi_menu_summary").append('<input class="smallerbox" type="submit" name="do_something" value="$button_text" />');
        $("#mainmenu").sortable({
            items: "li",
            opacity: 0.6,
//                 cursor: 'move',
            containment: 'form.adi_menu_summary',
            grid: [10, 10],
//                 connectWith: ".connectedSortable"
        });
        // update sort values
        $("#mainmenu").bind("sortstop",function(event, ui) {
            $('input.sort_value').each(function(i) { // renumber sort values
                var this_input = $(this);
                this_input.val(i+1);
            });
        });
        // auto toggle strikethrough class when click tick "exclude"
        $("tr td input.checkbox").click(function(){
            tr = $(this).parent().parent();
            $(tr).find(">:first-child a").toggleClass("adi_menu_excluded"); // section name
            $(tr).find(">:nth-child(2) span").toggleClass("adi_menu_excluded"); // title
            $(tr).find(">:nth-child(3) input").toggleClass("adi_menu_excluded"); // alternative title
            $(tr).find(">:nth-child(8) input").toggleClass("adi_menu_excluded"); // clone title
        });
    });
</script>
END_SCRIPT;
}

function adi_menu_style() {
// some style for the admin page

    echo
        '<style type="text/css">
            /* adi_menu */
            .adi_menu_warning { margin:1em; text-align:center }
            .adi_menu_form h1 { display:none }
            .adi_menu_form input.publish { margin-top:1em }
            .adi_menu_form table tr:nth-child(2n) { background-color:#eee }
            .adi_menu_form td:nth-child(3) input { font-style:italic } /* alt title */
            .adi_menu_form td:nth-child(4), .adi_menu_form td:nth-child(7) { text-align:center } /* exclude & clone */
            .adi_menu_form input[type=text] { width:10em }
            .adi_menu_form select { width:10em }
            .adi_menu_hide { display:none }
            #adi_menu_summary { margin:2em 0 2em; padding:1em 0 2em; border:solid #ccc; border-width:0.1em 0 0 }
            #adi_menu_summary ul li li { margin-left:2em }
            #adi_menu_summary .adi_menu_key span { color:#004cbf }
            #adi_menu_summary .menu_redirect > a { font-weight:bold }
            #adi_menu_summary .menu_alt_title > a { font-style:italic }
            #adi_menu_summary .menu_virtual > a:before { content:"\0022" }
            #adi_menu_summary .menu_virtual > a:after { content:"\0022" }
            #adi_menu_summary ul { margin-bottom:0.5em } /* helps drag&drop */
            #adi_menu_summary #mainmenu { margin-bottom:2em } /* helps drag&drop */
            #adi_menu_summary.adi_menu_drag_drop ul li { list-style-type:none }
            #adi_menu_summary.adi_menu_drag_drop ul li:before { content: "\2195\00a0"; }
/*			.adi_menu_summary_note_drag_drop { display:none }
            #adi_menu_summary.adi_menu_drag_drop .adi_menu_summary_note_drag_drop { display:block } */
            .adi_menu_excluded, #adi_menu_summary .adi_menu_key span span, #adi_menu_summary li.adi_menu_excluded > a { color:#aaa }
        </style>';
}

function adi_menu_strip_prefix($text) {
// strip "v_" from front of supplied text
    global $adi_menu_vs_prefix;

    $text = trim($text);
    return (strpos($text, $adi_menu_vs_prefix) === 0) ? substr($text, strlen($adi_menu_vs_prefix)) : $text;
}

function adi_menu_is_virtual($name) {
// section deemed to be virtual if:
//        - its 'adi_menu_id' value in section_list is not NULL (i.e. set to 'adi_menu' table row id )
//        - OR if not found in $section_list & its name begins with "v_"
    global $section_list, $adi_menu_vs_prefix;

    $name = trim($name);
    if (isset($section_list[$name])) // requested section found is known
        return ($section_list[$name]['adi_menu_id'] !== NULL);
    else // requested section not found, so based verdict on its name
        return (strpos(trim($name), $adi_menu_vs_prefix) === 0);
}

function adi_menu_display_settings($input_sections, $all_sections, $hide_links, $hide_cats) {
// generate section's table row in admin settings table
    global $prefs;

    $out = '';

    // determine last key of sections arrays (PHP 7's array_key_last would be handy here)
    $last_input_keys = array_keys($input_sections);
    $last_input_key = end($last_input_keys);
    $last_all_keys = array_keys($all_sections);
    $last_all_key = end($last_all_keys);

    // count virtual sections
    $vs_count = safe_count('adi_menu', '1=1');

    // add new virtual section input fields (on last page of sections)
    if ($last_input_key == $last_all_key) {
        $input_sections[0]['adi_menu_id'] = 0; // zero = add new virtual section
        $input_sections[0]['name'] = '';
        $input_sections[0]['title'] = '';
        $input_sections[0]['adi_menu_parent'] = '';
        $input_sections[0]['adi_menu_title'] = '';
        $input_sections[0]['adi_menu_exclude'] = 0;
        $input_sections[0]['adi_menu_clone'] = 0;
        $input_sections[0]['adi_menu_sort'] = 255; // the maximum value for an INT(3)
        $input_sections[0]['adi_menu_redirect_section'] = '';
        $input_sections[0]['adi_menu_redirect_link'] = '';
        $input_sections[0]['adi_menu_alt_title'] = '';
        $input_sections[0]['adi_menu_redirect_category'] = '';
    }

    foreach ($input_sections as $index => $section) {
        $id = $section['adi_menu_id']; // NULL = normal section, number = virtual section, zero = add new virtual section
        $name = $section['name'];
        $title = $section['title'];
        $parent = $section['adi_menu_parent'];
        $clone_title = $section['adi_menu_title'];
        $exclude = $section['adi_menu_exclude'];
        $clone = $section['adi_menu_clone'];
        $sort = $section['adi_menu_sort'];
        $redirect_section = $section['adi_menu_redirect_section'];
        $redirect_link = $section['adi_menu_redirect_link'];
        $alt_title = $section['adi_menu_alt_title'];
        $redirect_category = $section['adi_menu_redirect_category'];
        $out .= tr(
            // section name/link to section tab (normal sections) OR input field (virtual sections)
            ($id === NULL
                ? tda(eLink('section', 'section_edit', 'name', $index, $index, '', '', '', ($exclude ? 'adi_menu_excluded' : '')))
                : tda(finput('text', "name[$index]", $name, ($exclude ? 'adi_menu_excluded' : ''), '', '', 0, 0, 'adi_menu_new_virtual', FALSE, FALSE, gTxt('adi_menu_virtual_section_new')))
            )
            // section title (input field for virtual sections)
            .tda(
                ($id !== NULL
                    ? finput("text", "title[$index]", $title, ($exclude ? 'adi_menu_excluded' : ''))
                    : span(htmlspecialchars($title), ($exclude ? ' class="adi_menu_excluded"' : ''))
                )
                .hinput("id[$index]", $id)
            )
            .tda(finput("text", "alt_title[$index]", $alt_title, ($exclude ? 'adi_menu_excluded' : '')))
            .tda(checkbox("exclude[$index]", "1", $exclude))
            .tda(adi_menu_section_popup($all_sections, $index, "parent[$index]", $parent, $vs_count))
            .tda(finput("text", "sort[$index]", $sort, '', '', '', 4), ' class="adi_menu_sort"') // hidden if jQuery-UI is available
            .tda(checkbox("clone[$index]", "1", $clone))
            .tda(finput("text", "clone_title[$index]", $clone_title, ($exclude ? 'adi_menu_excluded' : '')))
            .tda(adi_menu_section_popup($all_sections, $index, "redirect_section[$index]", $redirect_section, $vs_count))
            .tda(adi_menu_link_popup("redirect_link[$index]", $redirect_link))
            .tda(adi_menu_category_popup("redirect_category[$index]", $redirect_category), $hide_cats) // may be hidden if there're no categories defined
            .tda(adi_menu_delete_button($id, $name))
        );
    }

    return $out;
}

function adi_menu_section_popup($section_list, $this_section, $select_name, $value, $vs_count) {
// generate section/virtual section popup list for admin settings table
    $out = '<option value=""></option>';

    $og_preamble = '<optgroup label="Sections">';
    $vs_og_preamble = '<optgroup label="Virtual Sections">';
    $og_postamble = '</optgroup>';
    if ($vs_count == 0) // only group sections if there're some virtuals
        $og_preamble = $vs_og_preamble = $og_postamble = '';

    $vs_found = FALSE;

    if ($section_list) {
        $out .= $og_preamble;
        foreach ($section_list as $section_name => $section) {
            if ($section_name) { // don't want section "0" (i.e. the "new" virtual section)
                $disabled = $selected = '';
                if ($this_section && ($section_name == $this_section)) // if it's not new virtual section ($this_section = 0), prevent loop
                    $disabled = ' disabled="disabled"'; // don't want to offer section as a parent of (or redirect to) itself
                if ($section_name == $value)
                    $selected = ' selected="selected"';
                if (!$vs_found && ($section['adi_menu_id'] !== NULL)) { // virtual sections subheading
                    $vs_found = TRUE;
                    $out .= $og_postamble.$vs_og_preamble;
                }
                if ($vs_found)
                    // value includes prefix (i.e. virtual section name), label shouldn't
                    $out .= '<option value="'.$section_name.'"'.$disabled.$selected.' class="adi_menu_virtual">'.adi_menu_strip_prefix($section_name).'</option>';
                else
                    $out .= '<option value="'.$section_name.'"'.$disabled.$selected.'>'.$section_name.'</option>';
            }
        }
        $out .= $og_postamble;
    }

    return tag($out, 'select', ' name="'.$select_name.'"');
}

function adi_menu_link_popup($select_name, $value) {
// generate link popup list for admin settings table
// TODO - make this non-DB like section_popup

    $rs = safe_rows('id, linkname', 'txp_link', '1=1');
    if ($rs)
        return selectInput($select_name, array_combine(array_column($rs, 'id'), array_column($rs, 'linkname')), $value, TRUE);

    return FALSE;
}

function adi_menu_category_popup($select_name, $value) {
// generate category popup list for admin settings table
// TODO - make this non-DB like section_popup

    $rs = safe_column('name', 'txp_category', 'name != "root" AND type="article"');
    if ($rs)
        return selectInput($select_name, $rs, $value, TRUE);

    return FALSE;
}

function adi_menu_delete_button($id, $name) {
// virtual section delete button [X]
    if ($id)
        return dLink('adi_menu_admin', 'delete', 'name', $name, '',  '', '', 1);
    return sp;
}

function adi_menu_table_found($table) {
// see if supplied table is present
    $rs = safe_query("SHOW TABLES LIKE '".safe_pfx($table)."'");
    $a = nextRow($rs);

    return ($a ? TRUE : FALSE);
}

function adi_menu_column_found($column, $table = 'txp_section') {
// check for presence of a column in a table
    global $adi_menu_db_debug;

    $rs = safe_query('SHOW FIELDS FROM '.safe_pfx($table)." LIKE '".$column."'", $adi_menu_db_debug); // find out if column exists
    $a = nextRow($rs);

    return !empty($a);
}

function adi_menu_installed() {
// if 'adi_menu_parent' column present then assume adi_menu is installed

    return(adi_menu_column_found('adi_menu_parent'));
}

function adi_menu_install() {
// add adi_menu's columns to txp_section table
    global $adi_menu_db_debug;

    if (adi_menu_installed())
        return TRUE;
    else // add basic columns to txp_section
        return safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_parent VARCHAR(128) DEFAULT ''", $adi_menu_db_debug)
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_title VARCHAR(128) DEFAULT ''", $adi_menu_db_debug) // clone title
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_exclude TINYINT(1) DEFAULT 0 NOT NULL", $adi_menu_db_debug)
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_clone TINYINT(1) DEFAULT 0 NOT NULL", $adi_menu_db_debug)
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_sort TINYINT(3) UNSIGNED DEFAULT 0 NOT NULL", $adi_menu_db_debug); // sort value only goes up to 255
// 			&& safe_update('txp_section', 'adi_menu_exclude = 0', "page != ''", $adi_menu_db_debug);
            // as of v1.5, adi_menu_exclude defaults to 1 but on install set all non-pageless section to include (adi_menu_exclude=0)
            // - sections added after install will need to be manually included
}

function adi_menu_uninstall() {
// remove adi_menu's columns from txp_section table
    global $adi_menu_db_debug;

    // remove columns
    $res = safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_parent", $adi_menu_db_debug)
        && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_title", $adi_menu_db_debug)
        && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_exclude", $adi_menu_db_debug)
        && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_clone", $adi_menu_db_debug)
        && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_sort", $adi_menu_db_debug);
    if (adi_menu_column_found('adi_menu_redirect_section')) // remove version 1.0 columns
        $res = $res
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_redirect_section", $adi_menu_db_debug)
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_redirect_link", $adi_menu_db_debug);
    if (adi_menu_column_found('adi_menu_accesskey')) // remove version 1.0beta only columns
        $res = $res
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_accesskey", $adi_menu_db_debug)
            && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_tabindex", $adi_menu_db_debug);
    if (adi_menu_column_found('adi_menu_alt_title')) // remove version 1.1 columns
        $res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_alt_title", $adi_menu_db_debug);
    if (adi_menu_column_found('adi_menu_redirect_category')) { // remove version 1.4 column & adi_menu_table
        $res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." DROP COLUMN adi_menu_redirect_category", $adi_menu_db_debug);
        $res = $res && safe_query("DROP TABLE ".safe_pfx('adi_menu'), $adi_menu_db_debug);
    }
    // delete preferences
    $res = $res && safe_delete('txp_prefs', "name LIKE 'adi_menu_%'", $adi_menu_db_debug);

    return $res;
}

function adi_menu_upgrade($do_upgrade = FALSE) {
// add additional adi_menu columns to txp_section table, if required
    global $DB, $adi_menu_debug, $adi_menu_db_debug, $adi_menu_sql_fields;

    if ($adi_menu_debug) echo __FUNCTION__.'():'.br;

    if (adi_menu_installed()) {
        // record the number of 'default' articles
        $rs = safe_rows('id', 'textpattern', "section='default'");
        adi_menu_prefs('write_tab_select_default', count($rs));
        // version 1.0 - new columns (adi_menu_redirect_section & adi_menu_redirect_link)
        $v1_0 = !adi_menu_column_found('adi_menu_redirect_section');
        // version 1.1 - new column (adi_menu_alt_title)
        $v1_1 = !adi_menu_column_found('adi_menu_alt_title');
        // version 1.4 - new column (adi_menu_redirect_category), new adi_menu table, sort value tweaks
        $v1_4 = !adi_menu_column_found('adi_menu_redirect_category');
        $v1_4s = $v1_5t = $v1_5 = FALSE;
        // adi_menu table is actually an upgrade, check that it exists
        if (adi_menu_table_found('adi_menu')) {
            // version 1.4 supplemental - add clone columns to adi_menu table
            $v1_4s = !adi_menu_column_found('clone_title', 'adi_menu');
            // version 1.5 - table checks
            extract($DB->table_options); // $charset, $collate, $engine
            $rs = safe_query("SHOW TABLE STATUS LIKE '".safe_pfx('adi_menu')."'", $adi_menu_db_debug);
            extract(nextRow($rs));
            if ($adi_menu_debug) echo "TXP charset=$charset, collate=$collate, engine=$engine ... adi_menu collate=$Collation, plugin_engine=$Engine".br;
            $v1_5t = ($Collation && $Engine && (($Collation != $collate) || ($Engine != $engine)));
            // new default for adi_menu_exclude (0 -> 1)
// 			$rs = safe_query("SHOW COLUMNS FROM ".safe_pfx('txp_section')." LIKE 'adi_menu_exclude'", $adi_menu_db_debug);
// 			extract(nextRow($rs));
// 			$v1_5 = !$Default;
        }
// 		$upgrade_required = $v1_0 || $v1_1 || $v1_4 || $v1_4s || $v1_5t || $v1_5;
// 		if ($adi_menu_debug) echo "v1_0=$v1_0, v1_1=$v1_1, v1_4=$v1_4, v1_4s=$v1_4s, v1_5t=$v1_5t, v1_5=$v1_5";
        $upgrade_required = $v1_0 || $v1_1 || $v1_4 || $v1_4s || $v1_5t;
        if ($adi_menu_debug) echo "v1_0=$v1_0, v1_1=$v1_1, v1_4=$v1_4, v1_4s=$v1_4s, v1_5t=$v1_5t";
        if ($do_upgrade) {
            if ($upgrade_required) {
                $res = TRUE;
                if ($v1_0)
                    $res = safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_redirect_section VARCHAR(128) DEFAULT ''", $adi_menu_db_debug)
                        && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_redirect_link TINYINT(3) UNSIGNED DEFAULT 0 NOT NULL", $adi_menu_db_debug);
                if ($v1_1)
                    $res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_alt_title VARCHAR(128) DEFAULT ''", $adi_menu_db_debug);
                if ($v1_4) {
                    $res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." ADD adi_menu_redirect_category VARCHAR(128) DEFAULT ''", $adi_menu_db_debug);
                    safe_create('adi_menu', "
                            id          INT             NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            name        VARCHAR(128)    NOT NULL,
                            title       VARCHAR(255)    NOT NULL DEFAULT '',
                            alt_title   VARCHAR(255)    NOT NULL DEFAULT '',
                            parent      VARCHAR(128)    NOT NULL DEFAULT '',
                            clone       TINYINT(1)      NOT NULL DEFAULT 0,
                            clone_title VARCHAR(255)    NOT NULL DEFAULT '',
                            exclude     TINYINT(1)      NOT NULL DEFAULT 0,
                            sort        TINYINT(3)      UNSIGNED NOT NULL DEFAULT 255,
                            section     VARCHAR(128)    NOT NULL DEFAULT '',
                            link        TINYINT(3)      UNSIGNED NOT NULL DEFAULT 0,
                            category    VARCHAR(128)    NOT NULL DEFAULT ''
                        ",
                        '', // no options
                        $adi_menu_db_debug
                    );
                    // force unique sort values (using $rs array index from "0") to ensure later use of (unstable) uasort doesn't cause problems
                    $rs = safe_rows($adi_menu_sql_fields, 'txp_section', "1=1 ORDER BY adi_menu_sort", $adi_menu_db_debug);
                    if ($rs)
                        foreach($rs as $index => $row)
                            $res = $res && safe_update('txp_section', 'adi_menu_sort="'.$index.'"', 'name="'.$row['name'].'"', $adi_menu_db_debug);
                    // new sections default to end of list (255 assigned to new virtual sections by adi_menu_update())
                    $res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." MODIFY COLUMN adi_menu_sort TINYINT(3) UNSIGNED DEFAULT 255 NOT NULL", $adi_menu_db_debug);
                }
                if ($v1_4s)
                    $res = safe_query("ALTER TABLE ".safe_pfx('adi_menu')." ADD clone TINYINT(1) DEFAULT 0 NOT NULL", $adi_menu_db_debug)
                        && safe_query("ALTER TABLE ".safe_pfx('adi_menu')." ADD clone_title VARCHAR(255) DEFAULT '' NOT NULL", $adi_menu_db_debug);
                if ($v1_5t) {
// 					$res = $res && safe_query("ALTER TABLE ".safe_pfx('adi_menu')." CONVERT TO CHARACTER SET $charset COLLATE $collate", $adi_menu_debug);
// 					$res = $res && safe_query("ALTER TABLE ".safe_pfx('adi_menu')." ENGINE = $engine", $adi_menu_debug);
                    $res = $res && safe_alter('adi_menu', "CONVERT TO CHARACTER SET $charset COLLATE $collate", $adi_menu_debug);
                    $res = $res && safe_alter('adi_menu', "ENGINE = $engine", $adi_menu_debug);
                }
// 				if ($v1_5) {
                    // change txp_section column adi_menu_exclude default => 1
// 					$res = $res && safe_query("ALTER TABLE ".safe_pfx("txp_section")." MODIFY COLUMN adi_menu_exclude TINYINT(1) DEFAULT 1 NOT NULL", $adi_menu_db_debug);
                    // if not cloned, lose clone title
// 					$res = $res && safe_update('adi_menu', 'clone_title = ""', 'clone != 1', $adi_menu_db_debug);
// 					$res = $res && safe_update('txp_section', 'adi_menu_title = ""', 'adi_menu_clone != 1', $adi_menu_db_debug);
                    // set clone title to "Summary" if cloned but clone title empty
// 					$res = $res && safe_update('adi_menu', 'clone_title = "Summary"', 'clone_title = "" AND clone = 1', $adi_menu_db_debug);
// 					$res = $res && safe_update('txp_section', 'adi_menu_title = "Summary"', 'adi_menu_title = "" AND adi_menu_clone = 1', $adi_menu_db_debug);
                    // delete column clone from both tables
// 					$res = $res && safe_query("ALTER TABLE ".safe_pfx('txp_section')." DROP COLUMN adi_menu_clone", $adi_menu_db_debug);
// 					$res = $res && safe_query("ALTER TABLE ".safe_pfx('adi_menu')." DROP COLUMN clone", $adi_menu_db_debug);
// 				}
                return $res;
            }
            else
                return TRUE;
        }
        else
            return $upgrade_required;
    }
    else
        return FALSE;
}

function adi_menu_lifecycle($event, $step) {
// such is life
    global $adi_menu_debug;

    $result = '?';
    $upgrade = (($step == "installed") && adi_menu_installed());
    if ($step == 'enabled')
            $result = $upgrade = adi_menu_install();
    else if ($step == 'deleted')
        $result = adi_menu_uninstall();
    if ($upgrade)
        $result = $result && adi_menu_upgrade(TRUE);
    if ($adi_menu_debug)
        echo "event=$event, step=$step, result=$result, upgrade=$upgrade";
}

function adi_menu_prefs($name, $new_value = NULL) {
// set/read preferences
    global $prefs, $adi_menu_prefs;

    if ($new_value !== NULL) { // save new value
        set_pref('adi_menu_'.$name, $new_value, 'adi_menu_admin', 2);
        $prefs['adi_menu_'.$name] = get_pref('adi_menu_'.$name, $new_value, TRUE);
    }
    // take value from $prefs or, if not set, from $adi_menu_prefs[])
    isset($prefs['adi_menu_'.$name]) ? $value = $prefs['adi_menu_'.$name] : $value = $adi_menu_prefs[$name];

    return $value;
}

function adi_menu_options($event, $step) {
// plugin options
    global $adi_menu_debug, $adi_menu_db_debug;

    $message = '';

    // check for upgrade
    if (adi_menu_installed())
        if (adi_menu_upgrade())
            $step = 'upgrade';

    // dance steps
    if ($step == 'upgrade') {
        $result = adi_menu_upgrade(TRUE);
        $result ? $message = gTxt('adi_upgraded') : $message = array(gTxt('adi_upgrade_fail'), E_ERROR);
    }
    else if ($step == 'install') {
        $result = adi_menu_install();
        $result ? $message = gTxt('adi_installed') : $message = array(gTxt('adi_install_fail'), E_ERROR);
    }
    else if ($step == 'uninstall') {
        $result = adi_menu_uninstall();
        $result ? $message = gTxt('adi_uninstalled') : $message = array(gTxt('adi_uninstall_fail'), E_ERROR);
    }
}

function adi_menu_admin($event, $step) {
// adi_menu admin action!
    global $prefs, $adi_menu_prefs, $adi_menu_debug, $adi_menu_db_debug, $adi_menu_vs_prefix;

    $message = '';

    if ($installed = adi_menu_installed()) {
        $upgrade_required = adi_menu_upgrade();
        if ($upgrade_required)
            $message = array(gTxt('adi_upgrade_required'), E_WARNING);
        if ($step == "pref_update") {
            foreach ($adi_menu_prefs as $name => $value) {
                if ($name == 'admin_pageby') continue; // hidden pref
                if ($adi_menu_debug)
                    echo $name.'='.ps($name).' ';
                adi_menu_prefs($name, doStripTags(ps($name)));
            }
               $message = gTxt('preferences_saved');
        }
        if ($step == "update") {
            $sections = adi_menu_section_list('', '', TRUE);
            $message = adi_menu_update($sections);
        }
        if ($step == "sort_update") {
            $message = adi_menu_sort_update();
        }
        if ($step == "delete") {
            $name = gps('name');
            safe_delete('adi_menu', 'name="'.$name.'"', $adi_menu_db_debug);
            $message = gTxt('adi_menu_virtual_section_deleted');
        }
        if (($step == 'update') || ($step == 'sort_update') || ($step == 'delete'))
            update_lastmod();
    }
    else // not installed
        $message = array(gTxt('adi_not_installed'), E_ERROR);

        pagetop('adi_menu admin', $message);

    if ($installed && !$upgrade_required) {

        // paging
        if ($step == 'adi_menu_admin_change_pageby') { // change of page length
            $qty = gps('qty');
            adi_menu_prefs('admin_pageby', $qty); // generates pref name adi_menu_admin_pageby
        }
        $dir = 'asc';
        $page = gps('page'); // get page number
        $pageby = adi_menu_prefs('admin_pageby'); // get current page size (or paging default, if not saved as pref)
        $total = safe_count('txp_section', "page != ''"); // count all sections (that are not pageless)
        $total += safe_count('adi_menu', '1=1'); // add virtual sections to the total
        list($page, $offset, $num_pages) = pager($total, $pageby, $page);
        $chunk = floor($offset / $pageby); // convert offset (# of sections) to array chunk number (i.e. blocks of $pageby)
        if ($adi_menu_debug)
            echo "PAGING: total=$total, pageby=$pageby, page=$page, offset=$offset, num_pages=$num_pages, chunk=$chunk".br;

        // get to work
        $all_sections = adi_menu_section_list('', '', TRUE, 'name');

        // work out what to display
        if ($pageby) {
            $chunks = array_chunk($all_sections, $pageby, TRUE);
            $input_sections = $chunks[$chunk];
        }

        if ($adi_menu_debug) {
            $section_list = adi_menu_section_list('', '', TRUE);
            echo 'SECTION LIST:';
            dmp($section_list);
            echo 'HIERARCHY:';
            $hierarchy = adi_menu_hierarchy($section_list);
            dmp($hierarchy);
            echo 'DESCENDANT LIST:';
            $descendant_list = array();
            $descendant_list = adi_menu_descendants($hierarchy, 'adi_menu_root');
            dmp($descendant_list);
            echo 'SECTION LEVELS:';
            $section_levels = adi_menu_section_levels($hierarchy);
            dmp($section_levels);
            echo 'CATEGORY/SECTION MAP:';
            $cat_section_map = adi_menu_cat_section_map($section_list);
            dmp($cat_section_map);
        }

        // SANITY CHECKS
        // section loops
        $out = array();
        foreach ($all_sections as $section => $section_data)
            if (adi_menu_loop_check($all_sections, $section_data['adi_menu_parent']))
                $out[] = adi_menu_strip_prefix($section).(adi_menu_is_virtual($section) ? ' (virtual)' : '');
        if ($out)
            echo tag('** '.gTxt('adi_menu_loop_warning').': '.implode(', ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // missing parents
        $missing_parents = adi_menu_parent_check($all_sections);
        $out = array();
        foreach ($missing_parents as $section => $parent)
            $out[] = adi_menu_strip_prefix($section).(adi_menu_is_virtual($section) ? ' (virtual)' : '').' -> '.$parent;
        if ($out)
            echo tag('** '.gTxt('adi_menu_parent_warning').': '.implode('; ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // missing redirect sections
        $missing_sections = adi_menu_redirect_section_check($all_sections);
        $out = array();
        foreach ($missing_sections as $section => $redirect_section)
            $out[] = adi_menu_strip_prefix($section).(adi_menu_is_virtual($section) ? ' (virtual)' : '').' -> '.$redirect_section;
        if ($out)
            echo tag('** '.gTxt('adi_menu_redirect_section_warning').': '.implode('; ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // missing redirect links
        $missing_links = adi_menu_redirect_link_check($all_sections);
        $out = array();
        foreach ($missing_links as $section => $link)
            $out[] = adi_menu_strip_prefix($section).(adi_menu_is_virtual($section) ? ' (virtual)' : '').' -> '.$link;
        if ($out)
            echo tag('** '.gTxt('adi_menu_redirect_link_warning').': '.implode('; ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // missing redirect categories
        $missing_categories = adi_menu_redirect_category_check($all_sections);
        $out = array();
        foreach ($missing_categories as $section => $category)
            $out[] = adi_menu_strip_prefix($section).(adi_menu_is_virtual($section)? ' (virtual)' : '').' -> '.$category;
        if ($out)
            echo tag('** '.gTxt('adi_menu_redirect_category_warning').': '.implode('; ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // real section names clashing with virtual section names (e.g. real 'v_asd' & virtual 'asd')
        $rs = safe_query('SELECT '.safe_pfx('txp_section').'.name, '.safe_pfx('adi_menu').'.name FROM '.safe_pfx('txp_section').', '.safe_pfx('adi_menu').' WHERE '.safe_pfx('txp_section').".name = concat('".$adi_menu_vs_prefix."',".safe_pfx('adi_menu').'.name);', $adi_menu_db_debug);
        $out = array();
        while ($a = nextRow($rs))
            $out[] = $adi_menu_vs_prefix.$a['name'].' (virtual '.$a['name'].')';
        if ($out)
            echo tag('** '.gTxt('adi_menu_duplicate_warning').': '.implode('; ', $out).' **', 'p', ' class="adi_menu_warning warning"');

        // hide redirect link column if there're no links defined
        $links_found = adi_menu_link_popup('test', '');
        $hide_links = ($links_found ? '' : ' class="adi_menu_hide"');

        // hide redirect categories column if there're no categories defined
        $categories_found = adi_menu_category_popup('test', '');
        $hide_cats = ($categories_found ? '' : ' class="adi_menu_hide"');

        // output adi_menu settings table
        echo form(
            hed(gTxt('adi_menu'), 1)
            .startTable('list', '', 'edit-table txp-list')
            .tag(
                tr(
                    hcell(gTxt('section'))
                    .hcell(gTxt('title'))
                    .hcell(gTxt('adi_alt_title'))
                    .hcell(gTxt('exclude'))
                    .hcell(gTxt('parent'))
                    .hcell(gTxt('sort_value'), '', ' class="adi_menu_sort"') // hidden if jQuery-UI is available
                    .hcell(gTxt('adi_clone'))
                    .hcell(gTxt('adi_clone_title'))
                    .hcell(gTxt('adi_redirect_section'))
                    .hcell(gTxt('adi_redirect_link'), '', $hide_links)
                    .hcell(gTxt('adi_redirect_category'), '', $hide_cats) // may be hidden if there're no categories defined
                    .hcell(sp) // delete buttons
                )
                , 'thead'
            )
            .adi_menu_display_settings($input_sections, $all_sections, $hide_links, $hide_cats)
            .endTable()
            .tag(
                fInput('submit', 'update', gtxt('save'), 'publish')
                .eInput('adi_menu_admin')
                .hInput('page', $page)
                .hInput('dir', $dir)
                .sInput('update')
                , 'div'
            )
            , ''
            , ''
            , 'post'
            , 'adi_menu_form'
        );

        // paging controls
        echo ($total > 12
            ? tag(
                ($total > $pageby ? nav_form($event, $page, $num_pages, 'name', $dir, '', '', $total, $pageby, '') : '')
                .Txp::get('\Textpattern\Admin\Paginator', $event, $step)->render($pageby)
                , 'div'
                , ' id="list_navigation" class="txp-navigation"'
            )
            : ''
        );

        // output hierarchy summary
        global $default_first, $include_children, $default_title, $menu_id, $escape, $clone_title, $parent_class, $list_id, $parent_link_class, $sub_menu_class; // globals: yuk!
        if ($installed) {
            $clone_title = 'Summary';
            $default_first = '1';
            $default_title = 'Home';
            $escape = '';
            $include_children = '1';
            $list_id = '1';
            $menu_id = 'mainmenu';
            $parent_class = 'menuparent';
            $parent_link_class = '';
            $sections = $exclude = '';
            $sub_menu_class = '';
            $sub_menu_link_class = '';
            $section_list = adi_menu_section_list('', '', TRUE); // excludes overridden
            $hierarchy = adi_menu_hierarchy($section_list);
            $out = adi_menu_markup($hierarchy, 0);
            echo '<div id="adi_menu_summary">';
            echo tag(gTxt('adi_summary'), 'h2');
            $summary_note = ' ('.gTxt('adi_menu_summary_note_key').').';
            $vs = safe_rows('name', 'adi_menu', '1=1 ORDER BY RAND() LIMIT 1');
            echo graf(gTxt('adi_menu_summary_note').'.'.sp.gTxt('adi_menu_summary_footnote').'.');
            if ($vs)
                echo graf(gTxt('adi_menu_summary_note_prefix').' "'.$adi_menu_vs_prefix.'", '.strtolower(gTxt('adi_for_example')).' '.tag('sections="'.$adi_menu_vs_prefix.$vs[0]['name'].'"', 'em').'.');
            echo graf(gTxt('adi_menu_summary_note_drag_drop').'.', ' class="adi_menu_summary_note_drag_drop"');
            echo graf(gTxt('adi_menu_summary_note_key2'), ' class="adi_menu_key"');
            echo implode($out);
            echo '</div>';
        }

    // plugin preferences
    if ($installed)
        echo form(
            tag(gTxt('tab_preferences'), "h2")
            .graf(
                gTxt('adi_write_tab_select_format')
                .sp.sp
                .tag(
                    radio('write_tab_select_format', 'name', (adi_menu_prefs('write_tab_select_format') == 'name'))
                    .sp
                    .gTxt('name')
                    , 'label'
                )
                .sp
                .tag(
                    radio('write_tab_select_format', 'title', (adi_menu_prefs('write_tab_select_format') == 'title'))
                    .sp
                    .gTxt('title')
                    , 'label'
                )
            )
            .graf(
                gTxt('adi_write_tab_select_indent')
                .sp.sp
                .tag(
                    radio('write_tab_select_indent', '0', (adi_menu_prefs('write_tab_select_indent') == '0'))
                    .sp
                    .gTxt('no')
                    , 'label'
                )
                .sp
                .tag(
                    radio('write_tab_select_indent', '1', (adi_menu_prefs('write_tab_select_indent') == '1'))
                    .sp
                    .gTxt('yes')
                    , 'label'
                )
            )
            .fInput('submit', 'do_something', gTxt('adi_update_prefs'), 'smallerbox', '', '')
            .eInput('adi_menu_admin')
            .sInput('pref_update')
            .hInput('page', $page)
            .hInput('dir', $dir)
            , ''
            , ''
            , 'post'
            , 'adi_menu_form'
        );
    }

    if ($adi_menu_debug) {
        echo 'PREFS:'.br; // should create list automatically
        foreach ($adi_menu_prefs as $name => $value)
            echo "$name: ".adi_menu_prefs($name).br;
    }
}

function adi_menu_update() {
// update DB tables:
//        adi_menu         txp_section
//        id               -
//        name             name
//        title            title
//        alt_title        adi_menu_alt_title
//        parent           adi_menu_parent
//        exclude          adi_menu_exclude
//        sort             adi_menu_sort
//        section          adi_menu_redirect_section
//        link             adi_menu_redirect_link
//        category         adi_menu_redirect_category
//        clone            adi_menu_clone (clone yes/no)
//        clone_title      adi_menu_title (clone title)
    global $adi_menu_db_debug, $adi_menu_vs_prefix;

    $message = gTxt('adi_menu_updated');

    $id = ps('id'); // hidden field (NULL = normal section, number = virtual section, zero = add new virtual section)
    $name = doStripTags(ps('name')); // virtual sections only
    $title = doStripTags(ps('title')); // virtual sections only
    $parent = doStripTags(ps('parent'));
    $clone_title = doStripTags(ps('clone_title'));
    $exclude = doStripTags(ps('exclude'));
    $clone = doStripTags(ps('clone'));
    $sort = doStripTags(ps('sort'));
    $redirect_section = doStripTags(ps('redirect_section'));
    $redirect_link = doStripTags(ps('redirect_link'));
    $alt_title = doStripTags(ps('alt_title'));
    $redirect_category = doStripTags(ps('redirect_category'));

    $name_pairs = array(); // for recording name changes

    foreach ($sort as $index => $not_used) { // using $sort array from POST data to get list of sections present in input data
        if ($id[$index] != '') { // VIRTUAL SECTIONS - update adi_menu table
            $where = 'id="'.$id[$index].'"';
            $set = array();
            $this_name = strtolower(sanitizeForUrl($name[$index]));
            $this_name = adi_menu_strip_prefix($this_name);
            $set[] = 'name="'.doSlash($this_name).'"';
            $set[] = 'title="'.doSlash((trim($title[$index]) == '' ? $name[$index] : $title[$index])).'"'; // don't want blank title, default to section name
            $set[] = 'alt_title="'.doSlash($alt_title[$index]).'"';
            $set[] = 'parent="'.doSlash($parent[$index]).'"';
            $set[] = 'clone_title="'.doSlash($clone_title[$index]).'"';
            empty($exclude[$index]) ? $set[] = 'exclude="0"' : $set[] = 'exclude="1"';
            empty($clone[$index]) ? $set[] = 'clone="0"' : $set[] = 'clone="1"';
            $set[] = 'sort="'.doSlash($sort[$index]).'"';
            $set[] = 'section="'.doSlash($redirect_section[$index]).'"';
            if (!empty($redirect_link)) { // there might not be any links defined in the TXP database!
                if ($redirect_link[$index] != '') // don't want to set integer field as '' (uses default 0 instead)
                    $set[] = 'link="'.doSlash($redirect_link[$index]).'"';
            }
            if (!empty($redirect_category)) // there might not be any categories defined in the TXP database!
                $set[] = 'category="'.doSlash($redirect_category[$index]).'"';
            // update database
            $set = implode(', ', $set);
            if ($id[$index] == '0') { // new virtual section
                if ($this_name) { // it has a name
                    $found = safe_row('name', 'adi_menu', 'name="'.$this_name.'"');
                    if ($found)
                        $message = array(gTxt('adi_menu_virtual_section_exists').' - '.$this_name, E_ERROR);
                    else
                        safe_insert('adi_menu', $set, $adi_menu_db_debug);
                }
            }
            else { // update existing virtual section
                $old_name = safe_field('name', 'adi_menu', $where, $adi_menu_db_debug);
                $res = safe_update('adi_menu', $set, $where, $adi_menu_db_debug);
                if ($res && ($old_name != $this_name)) // record name change for later parent updates
                    $name_pairs[] = array('old' => $old_name, 'new' => $this_name);
            }
        }
        else { // NORMAL SECTIONS - update txp_section table
            $where = 'name="'.$index.'"';
            $set = array();
            $set[] = 'adi_menu_parent="'.doSlash($parent[$index]).'"';
            $set[] = 'adi_menu_title="'.doSlash($clone_title[$index]).'"';
            empty($exclude[$index]) ? $set[] = 'adi_menu_exclude="0"' : $set[] = 'adi_menu_exclude="1"';
            empty($clone[$index]) ? $set[] = 'adi_menu_clone="0"' : $set[] = 'adi_menu_clone="1"';
            $set[] = 'adi_menu_sort="'.doSlash($sort[$index]).'"';
            $set[] = 'adi_menu_alt_title="'.doSlash($alt_title[$index]).'"';
            $set[] = 'adi_menu_redirect_section="'.doSlash($redirect_section[$index]).'"';
            if (!empty($redirect_link)) { // there might not be any links defined in the TXP database!
//              if ($redirect_link[$index] != '') // don't want to set integer field as '' (uses default 0 instead)
            //  $set[] = 'adi_menu_redirect_link="'.doSlash($redirect_link[$index]).'"';
                if (empty($redirect_link[$index])) // can't set integer column to '' (use 0 instead)
                    $set[] = 'adi_menu_redirect_link="0"';
                else
                    $set[] = 'adi_menu_redirect_link="'.doSlash($redirect_link[$index]).'"';
            }
            if (!empty($redirect_category)) // there might not be any categories defined in the TXP database!
                $set[] = 'adi_menu_redirect_category="'.doSlash($redirect_category[$index]).'"';
            // update database
            $set = implode(', ', $set);
            safe_update('txp_section', $set, $where, $adi_menu_db_debug);
        }
    }

    // name changes? meet the new parents
    foreach ($name_pairs as $pair) {
        safe_update('adi_menu', 'parent="'.$adi_menu_vs_prefix.$pair['new'].'"', 'parent="'.$adi_menu_vs_prefix.$pair['old'].'"', $adi_menu_db_debug);
        safe_update('txp_section', 'adi_menu_parent="'.$adi_menu_vs_prefix.$pair['new'].'"', 'adi_menu_parent="'.$adi_menu_vs_prefix.$pair['old'].'"', $adi_menu_db_debug);
    }

    return $message;
}

function adi_menu_sort_update() {
// update database with drag & drop sort values
    global $adi_menu_db_debug, $adi_menu_vs_prefix;

    $sort = ps('sort');
    $virtual_sort = ps('virtual_sort');

    if ($sort)
        foreach ($sort as $name => $value)
            $res = safe_update('txp_section', 'adi_menu_sort="'.$value.'"', 'name="'.$name.'"', $adi_menu_db_debug);
    if ($virtual_sort)
        foreach ($virtual_sort as $name => $value)
            $res = $res & safe_update('adi_menu', 'sort="'.$value.'"', 'name="'.adi_menu_strip_prefix($name).'"', $adi_menu_db_debug);

    if ($res)
        $message = gTxt('adi_menu_order_updated');
    else
        $message = gTxt('adi_menu_order_update_failed');

    return $message;
}

function adi_menu_loop_check($section_list, $parent, $ancestors = array()) {
// check for section parent/child loops, return TRUE if loop found

    if (empty($parent)) // no more ancestors
        return FALSE;
    else {
        if (array_key_exists($parent, $ancestors)) // loop found
            return TRUE;
        else {
            $ancestors[$parent] = ''; // add parent to list of ancestors
            if (array_key_exists($parent, $section_list)) // check that parent exists (section rename issue)
                return adi_menu_loop_check($section_list, $section_list[$parent]['adi_menu_parent'], $ancestors);
            else
                return FALSE;
        }
    }
}

function adi_menu_parent_check($all_sections) {
// check for missing parents or link IDs

    $missing_parents = array();
    foreach($all_sections as $section => $value) {
        $parent = $value['adi_menu_parent'];
        if (!empty($parent))
            if (!array_key_exists($parent, $all_sections)) // check that parent exists (section deleted/renamed?)
                $missing_parents[$section] = $parent;
    }

    return $missing_parents;
}

function adi_menu_redirect_section_check($all_sections) {
// check section redirects

    $missing_sections = array();
    foreach($all_sections as $section => $value) {
        $redirect_section = $value['adi_menu_redirect_section'];
        if (!empty($redirect_section))
            if (!array_key_exists($redirect_section, $all_sections)) // check that redirect section exists (section deleted/renamed?)
                $missing_sections[$section] = $redirect_section;
    }

    return $missing_sections;
}

function adi_menu_redirect_category_check($all_sections) {
// check category redirects
// TODO - make this non-DB (& for category_popup as well)

    $missing_categories = array();

    $db_cats = safe_column('name', 'txp_category', 'name != "root" AND type="article"');

    if ($db_cats)
        foreach($all_sections as $section => $value) {
            $redirect_category = $value['adi_menu_redirect_category'];
            if (!empty($redirect_category))
                if (!array_key_exists($redirect_category, $db_cats)) // check that redirect section exists (section deleted/renamed?)
                    $missing_categories[$section] = $redirect_category;
        }

    return $missing_categories;
}

function adi_menu_redirect_link_check($all_sections) {
// check link redirects

    $missing_links = array();
    foreach($all_sections as $section => $value) {
        $link = $value['adi_menu_redirect_link'];
        if ($link)
            if (!adi_menu_get_link($link)) // check that link exists (link deleted?)
                $missing_links[$section] = $link;
    }

    return $missing_links;
}

function adi_menu_get_link($link_id) {
// read link from TXP database

    $url = '';
    if ($link_id) {
        $a = safe_row('url', 'txp_link', "id=$link_id");
        if ($a) // check if link ID actually exists
            $url = $a['url'];
        else
            $url = '';
    }

    return $url;
}

function adi_menu_section_sort($a, $b) {

    return $a['adi_menu_sort'] - $b['adi_menu_sort'];
}

function adi_menu_section_list($sections = '', $exclude_list = '', $override_exclude = FALSE, $sort = 'adi_menu_sort') {
// create list of required sections in array indexed by section/v_section name =>
//         'name' => 'section/v_section name'
//         'title' => 'Section title'
//         'adi_menu_parent' => 'section/v_section name'
//         'adi_menu_title' => 'Clone title'
//         'adi_menu_exclude' => '0/1'
//         'adi_menu_clone' => '0/1'
//         'adi_menu_clone_title' => 'clone title'
//         'adi_menu_sort' => 'x'
//         'adi_menu_redirect_section' => 'section name'
//         'adi_menu_redirect_link' => 'link id#'
//         'adi_menu_redirect_category' => 'article category name'
//         'adi_menu_alt_title' => 'Alternative title'
//         'url' => 'generated link, based on section or redirects'
//         'adi_menu_id' => NULL for section, id# for v_section

// $sections - BLANK = all, LIST = only include these in menu (others pruned out of hierarchy later - after adi_menu_section_list() call in adi_menu()) CONFUSING!
// $exclude_list - LIST = explicitly excluded
// $override_exclude - TRUE = blanket override exclude for all, FALSE = obey exclude, LIST = explicit list of section to override exclude

    global $adi_menu_debug, $default_first, $default_title, $adi_menu_sql_fields, $adi_menu_vs_sql_fields, $adi_menu_vs_prefix, $prefs, $relative_urls;

    $section_list = array();

    // decide how big the net's going to be
    if ($override_exclude && ($override_exclude === TRUE)) {
        $bulkq = "page != ''"; // all (with-page) sections regardless
        $bulkvq = "1=1"; // all sections regardless
    } else { // only sections that haven't been excluded in admin (with the possibility of an explicit override later)
        $bulkq = "page != '' AND adi_menu_exclude = 0";
        $bulkvq = "exclude = 0";
    }

    if ($adi_menu_debug) {
        echo __FUNCTION__.'():'.br;
        echo "SUPPLIED: sections='$sections'; exclude_list='$exclude_list'; override_exclude='$override_exclude'".br;
    }

    // it's a start
    $includeq = $bulkq;
    $includevq = $bulkvq;

    // explicit list of included sections (will override admin excluded)
    if ($sections) {
        $includeq = do_list($sections);
        $includevq = array();
        foreach ($includeq as $index => $this_section) // split real & virtual sections
            if (adi_menu_is_virtual($this_section)) { // have to check name prefix
                $includevq[] = adi_menu_strip_prefix($this_section); // strip prefix & add to list
                unset($includeq[$index]);
            }
        $includeq = implode("','", doSlash($includeq)); // "','" ensures that each section name is single-quoted in list (first & last quote added below)
        if ($includeq)
            $includeq = "($bulkq OR name IN ('$includeq'))"; // brackets required to protect from operator precedence
        else
            $includeq = $bulkq;
        $includevq = implode("','", doSlash($includevq));
        if ($includevq)
            $includevq = "($bulkvq OR name IN ('$includevq'))"; // brackets required to protect from operator precedence
        else
            $includevq = $bulkvq;
    }

    $excludeq = $excludevq = '';

    // explicit list of excluded sections
    if ($exclude_list) {
        $excludeq = do_list($exclude_list);
        $excludevq = array();
        foreach ($excludeq as $index => $this_section) // split real & virtual sections
            if (adi_menu_is_virtual($this_section)) { // have to check name prefix
                $excludevq[] = adi_menu_strip_prefix($this_section); // strip prefix & add to list
                unset($excludeq[$index]);
            }
        $excludeq = implode("','", doSlash($excludeq));
        if ($excludeq)
            $excludeq = " AND name NOT IN ('$excludeq')";
        else
            $excludeq = '';
        $excludevq = implode("','", doSlash($excludevq));
        if ($excludevq)
            $excludevq = " AND name NOT IN ('$excludevq')";
        else
            $excludevq = '';
    }

    $override_excludeq = $override_excludevq = '';

    // explicit list of override-exclude sections
    if ($override_exclude && ($override_exclude !== TRUE)) {
        $override_excludeq = do_list($override_exclude);
        $override_excludevq = array();
        foreach ($override_excludeq as $index => $this_section) // split real & virtual sections
            if (adi_menu_is_virtual($this_section)) { // have to check name prefix
                $override_excludevq[] = adi_menu_strip_prefix($this_section); // strip prefix & add to list
                unset($override_excludeq[$index]);
            }
        $override_excludeq = implode("','", doSlash($override_excludeq));
        if ($override_excludeq)
            $override_excludeq = " OR name IN ('$override_excludeq')";
        else
            $override_excludeq = '';
        $override_excludevq = implode("','", doSlash($override_excludevq));
        if ($override_excludevq)
            $override_excludevq = " OR name IN ('$override_excludevq')";
        else
            $override_excludevq = '';
    }

    $sortq = " ORDER BY $sort";

    $q = $includeq.$excludeq.$override_excludeq.$sortq;
    $vq = $includevq.$excludevq.$override_excludevq.$sortq;

    if ($adi_menu_debug) {
        echo "NORMAL QUERY (COMPONENTS): bulkq='$bulkq'; includeq='$includeq'; excludeq='$excludeq'; override_excludeq='$override_excludeq'; sortq='$sortq'".br;
        echo "NORMAL QUERY (COMPILED): $q".br;
        echo "VIRTUAL QUERY (COMPONENTS): bulkvq='$bulkvq'; includevq='$includevq'; excludeq='$excludevq'; override_excludevq='$override_excludevq'; sortq='$sortq'".br;
        echo "VIRTUAL QUERY (COMPILED): $vq".br;
    }

    $hu = isset($prefs['url_base']) ? $prefs['url_base'] : hu;

    $rs = safe_rows_start($adi_menu_sql_fields, 'txp_section', $q);
    if ($rs) {
        // real sections
        if ($adi_menu_debug) echo "NORMAL SECTIONS: ";
        while ($a = nextRow($rs)) {
            if ($adi_menu_debug) echo $a['name'].sp;
            $found_as_virtual_section = FALSE;
            if (preg_match('/\A'.$adi_menu_vs_prefix.'/', $a['name'])) // look for clash of name in adi_menu, in the (hopefully) unlikely event that someone adds a section prefixed with "v_"
                $found_as_virtual_section = safe_row('name', 'adi_menu', ' name="'.adi_menu_strip_prefix($a['name']).'"');
            if (!$found_as_virtual_section) {
                $a['adi_menu_id'] = NULL;
                // create URL & add it to $a, noting any redirection along the way
                if ($a['adi_menu_redirect_section'])
                    $a['url'] = pagelinkurl(array('s' => $a['adi_menu_redirect_section']));
                else if ($a['adi_menu_redirect_link'])
                        $a['url'] = adi_menu_get_link($a['adi_menu_redirect_link']);
                else if ($a['adi_menu_redirect_category'])
                    $a['url'] = pagelinkurl(array('c' => $a['adi_menu_redirect_category']));
                else
                    $a['url'] = pagelinkurl(array('s' => $a['name']));
                if ($relative_urls) $a['url'] = str_replace($hu, '/', $a['url']); // relative_urls
                $section_list[$a['name']] = $a;
            }
        }
        if ($adi_menu_debug) echo br;
        // virtual sections
        $vs_rs = safe_rows_start($adi_menu_vs_sql_fields, 'adi_menu', $vq);
        if ($vs_rs) {
            if ($adi_menu_debug) echo "VIRTUAL SECTIONS: ";
            while ($a = nextRow($vs_rs)) {
                if ($adi_menu_debug) echo $a['name'].sp;
                // create URL & add it to $a, noting any redirection along the way
                if ($a['adi_menu_redirect_section'])
                    $a['url'] = pagelinkurl(array('s' => $a['adi_menu_redirect_section']));
                else if ($a['adi_menu_redirect_link'])
                        $a['url'] = adi_menu_get_link($a['adi_menu_redirect_link']);
                else if ($a['adi_menu_redirect_category'])
                    $a['url'] = pagelinkurl(array('c' => $a['adi_menu_redirect_category']));
                else
                    $a['url'] = '#'; // set null link URL if no section/link/category
                if ($relative_urls) $a['url'] = str_replace($hu, '/', $a['url']); // relative_urls
                $section_list[$adi_menu_vs_prefix.$a['name']] = $a; // virtual sections are prefixed
            }
            if ($adi_menu_debug) echo br;
        }
        // sort real & virtual sections
        if ($sort == 'adi_menu_sort') // sort array based on adi_menu_sort (otherwise virtual sections always come last)
            uasort($section_list, 'adi_menu_section_sort');

        // deal with default section
        if (array_key_exists('default', $section_list)) { // default section included in menu
            if ($section_list && $default_title) // set default section title
                $section_list['default']['title'] = $default_title;
            if ($section_list && $default_first) { // shift default section to beginning
                $remember['default'] = $section_list['default']; // remember 'default' element
                unset($section_list['default']); // remove 'default' element
                $section_list = $remember + $section_list; // join together, 'default' now at beginning ... don't use array_merge - it'll renumber numeric keys (e.g. section name = "2020")
            }
        }

        if ($adi_menu_debug) echo br;
    }

    return $section_list;
}

function adi_menu_section_titles($event, $step, $default, $data) {
// ripped off from rah_section_titles

    $rs = safe_rows('name, title', 'txp_section', "name != 'default' ORDER BY title ASC");
    if (!$rs) return;

    $section_levels = (adi_menu_prefs('write_tab_select_indent') ? adi_menu_section_levels(adi_menu_hierarchy(adi_menu_section_list('', '', TRUE))) : array());
    $title_mode = (adi_menu_prefs('write_tab_select_format') != 'name');

    $out = array();
    foreach ($rs as $a) {
        extract($a);
        $indent = (isset($section_levels[$name]) ? str_repeat('- ', $section_levels[$name] - 1) : '' ); // indent according to hierarchy (if section_levels set up)
        $out[$a['name']] = $indent.($title_mode ? $a['title'] : $a['name']); // convert name to title
    }

    if ($section_levels) { // indenture
        // order according to menu hierarchy
        $ordered_out = array();
        foreach ($section_levels as $section_name => $level) {
            if ($section_name == 'default')
                if (!adi_menu_prefs('write_tab_select_default')) // only allow it if there are some 'default' articles
                    continue;
            $ordered_out[$section_name] = $out[$section_name];
            unset($out[$section_name]);
        }
        $out = $ordered_out + $out; // add leftovers (i.e. pageless) back in
    }

    return
        preg_replace(
            '/<select[^>]*?>[\s\S]*?<\/select>/'
            , selectInput('Section', $out, $data['Section'], '', '', 'section')
            , $default
        );
}



function adi_menu_article_section_popup() {
// generate markup for section popup menu for Article/Write tab
    global $step, $section_list, $adi_menu_sed_sf_installed, $adi_menu_vs_prefix;

    $section_list = adi_menu_section_list('', '', TRUE);
    $hierarchy = adi_menu_hierarchy($section_list);
    $section_levels = adi_menu_section_levels($hierarchy);
    if ($step == 'edit') { // editing existing ($step = GET var) or creating new article ($step = POST var)
        if (!empty($GLOBALS['ID'])) // newly-saved article, get section from POST vars
            $select_section = gps('Section');
        else { // existing article, get ID from GET vars & section from database
            $article_id = gps('ID');
            if (is_int($article_id)) $select_section = safe_field("section", "textpattern", "id=".$article_id);
        }
    }
    if (!isset($select_section)) // empty article or no section found
        $select_section = getDefaultSection(); // default section for articles (defined in Sections tab)
    $out = 'name="Section" class="list">';
    foreach ($section_levels as $name => $level) { // create indented section popup list
        if ($adi_menu_sed_sf_installed) { // sed_sections_fields installed & active so check if static section
            $data = _sed_sf_get_data($name);
            $data_array = sed_lib_extract_name_value_pairs($data);
            if (isset($data_array['ss']))
                $ss = $data_array['ss']; // 0 or 1 from prefs
            else
                $ss = 0; // not found in prefs
            if ($ss) // static section according to sed_section_fields
                if (!has_privs('sed_sf.static_sections')) // only Publisher should see static sections
                    continue; // omit from section select list
        }
        if ($name == 'default') // shouldn't really have 'default' in the list
            if (!adi_menu_prefs('write_tab_select_default')) // only allow it if there're some 'default' articles
                continue;
        if (adi_menu_is_virtual($name)) // exclude virtual sections
            continue;
        if( strcasecmp($name, $select_section) == 0)
            $selected = ' selected="selected"';
        else
            $selected = '';
        if (adi_menu_prefs('write_tab_select_format') == 'name')
            $display = $name;
        else // must be 'title' then
            $display = $section_list[$name]['title'];
        $out .= '<option value="'.$name.'"'.$selected.'>';
        if (adi_menu_prefs('write_tab_select_indent')) // indent
            $out .= adi_menu_section_indent($level);
        $out .= $display.'</option>';
    }
    $out .= '</select>';
    return $out;
}

function adi_menu_section_levels($hierarchy, $level = 1) {
// create list, indexed by section, of level in hierarchy (top = 1 etc.)

    $section_levels = array();
    foreach ($hierarchy as $index => $section)
        if (!$section['clone']) { // ignore clones
            $section_levels[$index] = $level; // set level in array, indexed by section name
            $section_levels = $section_levels + adi_menu_section_levels($section['child'], $level + 1); // don't use array_merge - it'll renumber numeric keys (e.g. section name = "2020")
        }

    return $section_levels;
}

function adi_menu_lineage($section_list, $child) {
// determine the ancestry & generate markup
    global $s, $adi_menu_lineage_count, $adi_menu_breadcrumb_atts, $is_article_list;

    extract($adi_menu_breadcrumb_atts);

    $out = array();
    if (!array_key_exists($child, $section_list)) { // bomb out if section not found (e.g. if $s is blank on error page)
        $out[] = '';
        return $out;
    }

    if ($s == $child) $adi_menu_lineage_count++;
    if ($adi_menu_lineage_count > 1) { // bomb out if loop found
        $out[] = "Warning, section loop found: ";
        return $out;
    }
    if ($section_list[$child]['adi_menu_parent']) // has parent
        $out = array_merge($out, adi_menu_lineage($section_list, $section_list[$child]['adi_menu_parent']));
    else { // top of the food chain
        if (($include_default) && ($child != 'default')) // if (include default) AND (not at 'default' yet)
            $out = array_merge($out, adi_menu_lineage($section_list, 'default')); // do extra, 'default' iteration
        else
            $out[] = doTag($label, $labeltag); // add the "You are here" bit
    }
    // entitlements
    $crumb = $child; // default to section name
    if ($title) {
        $crumb = $section_list[$child]['title'];
        if (($crumb == 'default') && ($default_title))
            $crumb = $default_title;
        if (!$ignore_alt_title && $section_list[$child]['adi_menu_alt_title'])
            $crumb = $section_list[$child]['adi_menu_alt_title'];
    }
    $crumb = adi_menu_htmlentities($crumb, $escape);
    if (($s == $child) && (!$link_last) && ($is_article_list)) // if (last breadcrumb) AND (link_last=0) AND (not single article), switch off link mode
        $link = FALSE;

    if ($link) // output section link, maybe
        $out[] = href($crumb, $section_list[$child]['url'], ($linkclass ? 'class="'.$linkclass.'"' : ''));
    else
        $out[] = $crumb;

    if ($s != $child) // add separator if not last crumb
        $out[] = $separator;

    return $out;
}

function adi_menu_breadcrumb($atts) {
// <txp:adi_menu_breadcrumb /> tag
    global $s, $default_first, $adi_menu_lineage_count, $adi_menu_breadcrumb_atts;

    $default_first = "1"; // used by adi_menu_section_list()

//     extract(lAtts(array(
//         'label'               => 'You are here: ',    // string to prepend to the output
//         'labeltag'            =>    '',               // tag to wrap around label
//         'separator'           => ' &#187; ',          // string to be used as the breadcrumb separator (default: >>)
//         'title'               => '1',                 // display section titles or not
//         'link'                => '1',                 // output sections as links or not
//         'linkclass'           => 'noline',            // class for breadcrumb links
//         'link_last'           => '0',                 // display last section crumb as link or not
//         'include_default'     => '1',                 // include 'default' section or not
//         'default_title'       => 'Home',              // title for 'default' section
//         'ignore_alt_title'    => '0',                 // choose to ignore the alternatve titles
//         'escape'              => '',                  // escape HTML entities in section titles
//     ), $atts));

    if (!adi_menu_installed()) return "<em>adi_menu not installed!</em>";

    $adi_menu_breadcrumb_atts = lAtts(array(
        'label'                => 'You are here: ',    // string to prepend to the output
        'labeltag'             =>    '',               // tag to wrap around label
        'separator'            => ' &#187; ',          // string to be used as the breadcrumb separator (default: >>)
        'title'                => '1',                 // display section titles or not
        'link'                 => '1',                 // output sections as links or not
        'linkclass'            => 'noline',            // class for breadcrumb links
        'link_last'            => '0',                 // display last section crumb as link or not
        'include_default'      => '1',                 // include 'default' section or not
        'default_title'        => 'Home',              // title for 'default' section
        'ignore_alt_title'     => '0',                 // choose to ignore the alternatve titles
        'escape'               => '',                  // escape HTML entities in section titles: "", "html", "htmlspecial" (default="" - htmlentities/ENT_COMPAT/UTF-8)
    ), $atts);
    extract($adi_menu_breadcrumb_atts);

    $default_title = trim($default_title);

    /* adi_menu_breadcrumb - main procedure */
    $section_list = adi_menu_section_list('', '', TRUE);
    $adi_menu_lineage_count = 0; // global variable used instead of static, so that adi_menu_breadcrumb can have multiple instances
    $out = adi_menu_lineage($section_list, $s);

    return implode($out);
}

function adi_menu_info($atts, $thing, $if_tag = 0) {
// combined <txp:adi_menu_info /> & <txp:adi_menu_if_info /> tag function
// <txp:adi_menu_info /> returns specific menu information for current/specified section(s)
// <txp:adi_menu_if_info /> - if/then/else conditional
    global $s, $thisarticle, $adi_menu_sql_fields, $adi_menu_vs_sql_fields, $adi_menu_info_types, $adi_menu_vs_prefix, $ignore_alt_title;

    // if or not if
    if ($if_tag) {
        extract(lAtts(array(
            'sections'         => '',        // defaults to current section (or article's section if in speaking block)
            'type'             => 'title',   // defaults to title (useful for testing if section exists)
            'value'            => '',
            'debug'            => 0,
        ), $atts));
        $condition = 0;
    }
    else {
        extract(lAtts(array(
            'sections'         => '',        // defaults to current section (or article's section if in speaking block)
            'type'             => 'title',   // defaults to title (for standard sections analogous to <txp:section title="1" />
            'escape'           => '',        // escape HTML entities in section titles: "", "html", "htmlspecial" (default="" - htmlentities/ENT_COMPAT/UTF-8)
            'wraptag'          => '',
            'class'            => '',
            'break'            => '',
            'breakclass'       => '',
            'debug'            => 0,
            // LABEL etc?
        ), $atts));
        $out = array();
    }

    // sensitivities
    if ($sections == '')
        if ($thisarticle) // we're in an article (e.g. when used in speaking block forms)
            $sections = $thisarticle['section'];
        else
            $sections = $s; // current section

    $sections = do_list($sections);
    $types = do_list($type);

    if (array_search('ancestors', $types) !== FALSE) // who do you think you are?
        $section_list = adi_menu_section_list('', '', TRUE); // all sections, no exclusions, override excluded

    // go through supplied list of sections
    foreach ($sections as $section) {
        if (adi_menu_is_virtual($section))
            $row = safe_row($adi_menu_vs_sql_fields, 'adi_menu', "name='".adi_menu_strip_prefix($section)."'", $debug);
        else
            $row = safe_row($adi_menu_sql_fields, 'txp_section', "name='$section'", $debug);
        if ($row) { // section found in DB
            if ($debug) {
                echo "DB row:";
                dmp($row);
            }
            // go through supplied list of types
            foreach ($types as $type) {
                $valid_types = array_keys($adi_menu_info_types);
                if (in_array($type, $valid_types)) { // valid type?
                    if (isset($adi_menu_info_types[$type])) { // known column?
                        if (($type == 'clone_title') && !$row[$adi_menu_info_types['clone']['column']]) continue; // don't output or find clone title if clone isn't switched on (future proofing)
                        if ($if_tag) { // CONDITIONAL INFO TAG (<txp:adi_menu_if_info />)
                            // run through columns to see if any are non-blanks or values that match
                            $columns = do_list($adi_menu_info_types[$type]['column']);
                            foreach ($columns as $column) {
                                $this_val = $row[$column];
                                if ($type == 'menu_title') { // menu_title is a special case
                                    if ($row['adi_menu_alt_title'] && !$ignore_alt_title) // alternative title overrides normal title & check ignore_alt_title attribute
                                        $this_val = $row['adi_menu_alt_title']; // use deduced value
                                }
                                if ($value == '') { // test value not supplied
                                    if ($this_val != $adi_menu_info_types[$type]['blank']) // condition TRUE if column is non-blank
                                        $condition += 1;
                                }
                                else {
                                    if ($value == $this_val) // condition TRUE if column matches supplied value
                                        $condition += 1;
                                }
                            }
                        }
                        else { // OUTPUT INFO TAG (<txp:adi_menu_info />)
                            // output non-blank value
                            $column = $adi_menu_info_types[$type]['column'];
                            if (strpos($column, ',') === FALSE) { // ignore lists of columns (used by <txp:adi_menu_if_info /> only)
                                $this_val = $row[$column];
                                if ($type == 'menu_title') { // menu_title is a special case
                                    if ($row['adi_menu_alt_title'] && !$ignore_alt_title) // alternative title overrides normal title & check ignore_alt_title attribute
                                        $this_val = $row['adi_menu_alt_title']; // use deduced value
                                }
                                if ($type == 'ancestors') { // ancestors is another special case
                                    $ancestors = adi_menu_get_ancestors($section_list, $section);
                                    $this_val = implode(',', $ancestors);
                                }
                                if ($this_val != $adi_menu_info_types[$type]['blank']) // only output value if not "blank"
                                    $out[] = adi_menu_htmlentities($this_val, $escape);
                            }
                        }
                    }
                }
            }
        }
    }

    if ($debug) {
        echo ($if_tag ? 'adi_menu_if_info ' : 'adi_menu_info ');
        echo 'attributes:';
        dmp($atts);
        echo 'sections:';
        dmp($sections);
        echo 'type mapping:';
        dmp($adi_menu_info_types);
        echo 'types:';
        dmp($types);
        if ($if_tag)
            echo "condition=$condition".br;
        echo "ignore_alt_title=$ignore_alt_title".br; // if we're in a speaking block ignore_alt_title=0/1, otherwise it's blank (i.e. vague global unset value)
    }

    if ($if_tag)
        return parse($thing, $condition);
    else
        return doWrap($out, $wraptag, $break, $class, $breakclass);
}

function adi_menu_if_info($atts, $thing) {
// <txp:adi_menu_if_info /> tag == <txp:adi_menu_info if_tag="1" />

    return adi_menu_info($atts, $thing, 1);
}

function adi_menu_get_article_attr($article_attr) {
// parse article_attr and return list, indexed by attribute name
// e.g. article_attr='time="any" limit="5"'

    // THERE MUST BE A BETTER WAY!
    $attr_list = preg_replace("#([a-z_]+=)#", ",\\1", $article_attr) . ","; // creates e.g. ',time="any",limit="5"'
    $attr_list = do_list($attr_list);
    $attributes = array();
    foreach ($attr_list as $index => $attr) {
        if ($attr) {
            $a = do_list($attr, '=');
            if (count($a) == 2) { // safety valve
                $attribute = trim($a[0]); // remove whitespace
                $value = trim($a[1]); // remove whitespace
                $value = trim($value, '"'); // remove double quotes
                $attributes[$attribute] = $value;
            }
        }
    }

    return $attributes;
}

function adi_menu_get_articles($section_list, $section_article_list, $category_article_list = array(), $debug = FALSE) {
// create list of articles from database, indexed by section/category & sub-indexed by article id (prefixed with 'article_')
// - sort value taken from article_sort attribute
// - much code taken from publish.php doArticles()
    global $s, $c, $adi_menu_debug, $article_sort, $section_article_sort, $article_attr, $active_articles_only, $cat_article_sort, $category_article_sort, $cat_article_attr, $adi_menu_vs_prefix;

    // anything to do?
    if (!($section_article_list || $category_article_list))
        return array();

    $article_list = $this_article_list = $attributes = array();

    // section/category - attributes
    if ($section_article_list) {
        $this_article_list = $section_article_list;
        $attributes = adi_menu_get_article_attr($article_attr);
    }
    else if ($category_article_list) {
        $this_article_list = $category_article_list;
        $attributes = adi_menu_get_article_attr($cat_article_attr);
    }

    // blankety blank
    $section = $category = $search = $id = $excerpted = $month = $author = $keywords = $custom = $frontpage = '';

    // set defaults
    $statusq = ' AND Status = 4';
    $time = " AND Posted <= NOW()";
    $limit = 9999;
    $offset = 0;

    // analyse article attributes
    foreach ($attributes as $attribute => $value) {
        switch ($attribute) {
            case 'author':
                if ($value)
                    $author = (!$value) ? '' : " AND AuthorID IN ('".implode("','", doSlash(do_list($value)))."')";
                break;
            case 'category':
                if ($value) {
                    $category = implode("','", doSlash(do_list($value)));
                    $category = (!$category)  ? '' : " AND (Category1 IN ('".$category."') OR Category2 IN ('".$category."'))";
                }
                break;
            case 'excerpted':
                if ($value)
                    $excerpted = ($value == 'y')  ? " AND Excerpt !=''" : '';
                break;
            case 'keywords':
                if ($value) {
                    $keys = doSlash(do_list($value));
                    foreach ($keys as $key) {
                        $keyparts[] = "FIND_IN_SET('".$key."',Keywords)";
                    }
                    $keywords = " AND (" . implode(' or ', $keyparts) . ")";
                }
                break;
            case 'limit':
                if ($value)
                    $limit = $value;
                break;
            case 'month':
                if ($value)
                    $month = (!$value) ? '' : " AND Posted LIKE '".doSlash($value)."%'";
                break;
            case 'offset':
                if ($value)
                    $offset = $value;
                break;
            case 'sort': // will override article_sort attribute
                if ($value)
                    $article_sort = $value;
                break;
            case 'status':
                if ($value) {
                    $status = in_array(strtolower($value), array('sticky', '5')) ? 5 : 4;
                    $statusq = ' AND Status = '.intval($status);
                }
                else // status attr value blank = live and stickies
                    $statusq = ' AND Status IN (4,5)';
                break;
            case 'time':
                switch ($value) {
                    case 'any':
                        $time = ""; break;
                    case 'future':
                        $time = " AND Posted > NOW()"; break;
                }
                break;
        }
    }

    // custom fields
    $customFields = getCustomFields();
    $customlAtts = array_null(array_flip($customFields));
    if ($customFields) {
        foreach($customFields as $cField)
            if (isset($attributes[$cField]))
                $customPairs[$cField] = $attributes[$cField];
        if(!empty($customPairs))
            $custom = buildCustomSql($customFields, $customPairs);
    }

    if ($debug) {
        echo "adi_menu_get_articles()";
        if ($section_article_list) echo " - SECTION:".br;
        if ($category_article_list) echo " - CATEGORY:".br;
    }

    // retrieve articles from database
    foreach ($this_article_list as $index => $this_item) {
        // section/category - select
        $this_section = '';
        if ($section_article_list) {
            $this_section = $this_item;
            if (adi_menu_is_virtual($this_item)) { // virtual section, so think about it
                if ($section_list[$this_item]['adi_menu_redirect_section']) // only interested if redirected to a section
                    $this_section = $section_list[$this_item]['adi_menu_redirect_section'];
                else
                    continue;
            }
            $section = " AND Section = '".doSlash($this_section)."'";
        }
        else if ($category_article_list)
            $category = " AND (Category1 = '".$this_item."' OR Category2 = '".$this_item."')";

        // section/category - sorting
        $sortq = $this_sort = '';
        if ($section_article_list)
            if (array_key_exists($this_item, $section_article_sort)) // section-specific article sort
                $this_sort = $section_article_sort[$this_item];
            else
                $this_sort = $article_sort; // default sort
        else if ($category_article_list)
            if (array_key_exists($this_item, $category_article_sort)) // category-specific article sort
                $this_sort = $category_article_sort[$this_item];
            else
                $this_sort = $cat_article_sort; // default sort
        if ($this_sort)
            $sortq = ' ORDER BY '.doSlash($this_sort);

        // WHERE clause
        $where = "1=1".$statusq.$time.$search.$id.$category.$section.$excerpted.$month.$author.$keywords.$custom.$frontpage;

        if ($debug) echo "$this_item".($this_section && ($this_section != $this_item) ? " (>>>$this_section)" : "").": $where $sortq".br;

        // database action
        $rs = safe_rows_start(
                "ID,Title,url_title,Posted,Section" // needed for permlinkurl()
                , 'textpattern'
                , $where.$sortq.' LIMIT '.intval($offset).', '.intval($limit)
            );
        while ($a = nextRow($rs)) {
            $this_index = 'article_'.$a['ID']; // create unique array index - for ID 23, index is article_23
            $article_list[$this_item][$this_index]['title'] = html_entity_decode($a['Title']); // ampersands are escaped in article titles (but not in section titles)
            $article_list[$this_item][$this_index]['url'] = permlinkurl($a);
            $article_list[$this_item][$this_index]['section'] = FALSE; // FALSE=article
            $article_list[$this_item][$this_index]['virtual_section'] = FALSE;
            $article_list[$this_item][$this_index]['sort'] = rand(); // THIS MAY TAKE SORT NUMBER FROM SOMEWHERE ELSE EVENTUALLY
            $article_list[$this_item][$this_index]['clone'] = FALSE; // dummy filler
            $article_list[$this_item][$this_index]['redirect_section'] = ''; // dummy filler
            $article_list[$this_item][$this_index]['redirect_link'] = ''; // dummy filler
            $article_list[$this_item][$this_index]['redirect_category'] = ''; // dummy filler
            $article_list[$this_item][$this_index]['alt_title'] = ''; // dummy filler
            $article_list[$this_item][$this_index]['parent'] = ''; // dummy filler
            $article_list[$this_item][$this_index]['child'] = array(); // dummy filler
        }
    }

    if ($debug) echo br;

    return $article_list;
}


function adi_menu_speaking_block($name, $redirect_section) {
// retrieve specified section's sticky article excerpt for the speaking block
    global $speaking_block_form, $adi_menu_vs_prefix;

    if ($redirect_section) // massage section name to match redirection
        $name = $redirect_section;

    $sb_tag_attr = 'section="'.$name.'" status="sticky"';
    if ($speaking_block_form) // use specified form
        $sb_article_tag = '<txp:article_custom '.$sb_tag_attr.' form="'.$speaking_block_form.'"/>';
    else // use default form
        $sb_article_tag = '<txp:article_custom '.$sb_tag_attr.'><txp:excerpt /></txp:article_custom>';

    $sb_text = trim(parse($sb_article_tag));

    if ($sb_text) // don't want empty spans
        return '<span class="speaking_block">'.$sb_text.'</span>';
}

function adi_menu_sort_hierarchy($a, $b) {
// comparison function for uasort()
    global $article_sort, $article_position;

    if ($article_position == 'dovetail')
        $this_sort = 'title';
    else
        $this_sort = $article_sort;
    $reverse = preg_match("/ desc/i", $this_sort);
    $this_sort = preg_replace("/ asc/i", "", $this_sort); // remove " asc" MULTIPLE SPACES!!!
    $this_sort = preg_replace("/ desc/i", "", $this_sort); // remove " desc" MULTIPLE SPACES!!!
    if (strcasecmp($this_sort, 'title') == 0)
        $reverse ?
            $res = strcasecmp($b["title"], $a["title"]) :
            $res = strcasecmp($a["title"], $b["title"]);
    else if (strcasecmp($this_sort, 'adi_menu_sort') == 0)
        $res = strcasecmp($a["sort"], $b["sort"]);
    else // no sort (i.e. database order)
        $res = 0;

    return $res;
}

function adi_menu_hierarchy($section_list, $article_list = array(), $cat_article_list = array(), $this_section = '', $clone = 0) {
// create $hierarchy, indexed by section/article_ID, using information from $section_list (and possibly article lists too)
    global $clone_title, $article_position, $default_first, $articles, $exclude_clone, $active_articles_only;

    $hierarchy = array();
    $not_restricted = TRUE;
    // active articles only?
    if (($this_section !== '') && $active_articles_only)
        $not_restricted = adi_menu_is_current($this_section, $section_list[$this_section]['adi_menu_redirect_category']);

    // insert "BEFORE" articles
    if (($this_section !== '') && ($article_position == 'before') && $articles && $not_restricted) {
        $this_category = $section_list[$this_section]['adi_menu_redirect_category'];
        if ($this_category) { // category articles
            if (array_key_exists($this_category, $cat_article_list))
                $hierarchy = $cat_article_list[$this_category];
        }
        else
            if (array_key_exists($this_section, $article_list)) // section articles
                $hierarchy = $article_list[$this_section];
    }

    // clone parent as its child
    if ($clone && !$exclude_clone) {
        $hierarchy[$this_section]['title'] =
            $section_list[$this_section]['adi_menu_title'] ?
                $section_list[$this_section]['adi_menu_title'] :
                $clone_title; // use default clone title
        $hierarchy[$this_section]['url'] = $section_list[$this_section]['url'];
        $hierarchy[$this_section]['section'] = TRUE; // I'm a section
        $hierarchy[$this_section]['virtual_section'] = FALSE; // clones can't be virtual
        $hierarchy[$this_section]['sort'] = rand(); // sort number
        $hierarchy[$this_section]['clone'] = TRUE; // I'm a clone
        $hierarchy[$this_section]['parent'] = $this_section;
        $hierarchy[$this_section]['redirect_section'] = $section_list[$this_section]['adi_menu_redirect_section'];
        $hierarchy[$this_section]['redirect_link'] = $section_list[$this_section]['adi_menu_redirect_link'];
        $hierarchy[$this_section]['redirect_category'] = $section_list[$this_section]['adi_menu_redirect_category'];
        $hierarchy[$this_section]['alt_title'] = ''; // a clone already has an "alternative title"!
        $hierarchy[$this_section]['child'] = array(); // that's enough inbreeding
    }

    // find children
    foreach ($section_list as $section_name => $section_data) {
        if ($section_data['adi_menu_parent'] == $this_section) { //??? sections without parent (='') match initial value of $this_section
            $hierarchy[$section_name]['title'] = $section_data['title'];
            $hierarchy[$section_name]['url'] = $section_data['url'];
            $hierarchy[$section_name]['section'] = TRUE; // I'm a section
            $hierarchy[$section_name]['virtual_section'] = $section_data['adi_menu_id'] !== NULL; // virtual section?
            $hierarchy[$section_name]['sort'] = $section_data['adi_menu_sort']; // adi_menu admin sort order
            $hierarchy[$section_name]['clone'] = FALSE; // I'm not a clone
            $hierarchy[$section_name]['parent'] = $section_data['adi_menu_parent'];
            $hierarchy[$section_name]['redirect_section'] = $section_data['adi_menu_redirect_section'];
            $hierarchy[$section_name]['redirect_link'] = $section_data['adi_menu_redirect_link'];
            $hierarchy[$section_name]['redirect_category'] = $section_data['adi_menu_redirect_category'];
            $hierarchy[$section_name]['alt_title'] = $section_data['adi_menu_alt_title'];
            $hierarchy[$section_name]['child'] = adi_menu_hierarchy($section_list, $article_list, $cat_article_list, $section_name, $section_data['adi_menu_clone']); // delve deeper
        }
    }

    // insert "AFTER/DOVETAIL" articles
    if (($this_section !== '') && !($article_position == 'before') && $articles && $not_restricted) { // default to inserting articles AFTER sections (i.e. not "before")
        $this_category = $section_list[$this_section]['adi_menu_redirect_category'];
        if ($this_category) { // category articles
            if (array_key_exists($this_category, $cat_article_list))
                $hierarchy = array_merge($hierarchy, $cat_article_list[$this_category]); // array_merge OK here
        }
        else
            if (array_key_exists($this_section, $article_list)) // section articles
                $hierarchy = array_merge($hierarchy, $article_list[$this_section]); // array_merge OK here
        if ($article_position == 'dovetail') // sort current level of hierarchy (sections AND articles)
            uasort($hierarchy, "adi_menu_sort_hierarchy");
    }

    return $hierarchy;
}

function adi_menu_prune($old_hierarchy, $include_list, $section_levels, $siblings) {
// remove sections from the hierarchy that are not on the include list (taking notice of: include_parent, include_childless, include_top_level)
    global $include_parent, $include_childless, $include_top_level, $include_siblings, $current_descendants_only;

    $hierarchy = array();

    foreach ($old_hierarchy as $section => $section_data) {

        if (array_search($section, $include_list) !== FALSE) { // IN LIST: copy section/children and look no further
            if (!empty($section_data['child']) && (!$include_parent)) // copy children only
                $hierarchy += $section_data['child'];
            else if (($include_parent) || ($include_childless)) // copy section (& children)
                $hierarchy[$section] = $section_data;
        }
        else if ($include_top_level && ($section_levels[$section] == 1)) { // NOT IN LIST: but check top level requirements
            $section_data['child'] = array(); // remove the kids
            $hierarchy[$section] = $section_data; // copy section (WITHOUT children)
        }
        else if ($include_siblings) { // NOT IN LIST: but check if sibling
            foreach ($include_list as $this_section) {
                if (array_search($section, $siblings[$this_section])) {
                        $section_data['child'] = array(); // remove the kids
                        $hierarchy[$section] = $section_data; // copy section (WITHOUT children)
                    }
            }
        }
        else if ($current_descendants_only) { // NOT IN LIST: add as parent only
            $section_data['child'] = array(); // remove the kids
            $hierarchy[$section] = $section_data; // copy section (WITHOUT children)
        }
        else if (!empty($section_data['child'])) // NOT IN LIST: delve deeper into hierarchy
            $hierarchy += adi_menu_prune($section_data['child'], $include_list, $section_levels, $siblings);

    }

    return $hierarchy;
}

function adi_menu_siblings($section_list) {
// create list of siblings

    $parents = $siblings = array();

    foreach ($section_list as $section => $section_data)
        $siblings[$section] = array();

    foreach ($section_list as $section => $section_data) {
        $parent = $section_data['adi_menu_parent'];
        if ($parent == '')
            $parents['adi_menu_root'][] = $section;
        else
            $parents[$parent][] = $section;
    }

    foreach ($parents as $parent => $children) {
        foreach ($children as $child) {
            $siblings[$child] = $children;
            if (($key = array_search($child, $siblings[$child])) !== FALSE) {
                unset($siblings[$child][$key]);
                $siblings[$child] = array_values($siblings[$child]); // re-index array
            }
        }
    }

    return $siblings;
}

function adi_menu_descendants($hierarchy, $parent) {
// create list of descendants, indexed by section/article ID
    global $descendant_list;

    foreach ($hierarchy as $index => $section) {
        // add child to parent's list
        $descendant_list[$parent][] = $index;
        if ($section['child']) { // found some grandchildren
            // follow the family tree
            adi_menu_descendants($section['child'], $index);
            // add child's descendants to parent's list
            $descendant_list[$parent] = array_merge($descendant_list[$parent], $descendant_list[$index]); // must use array_merge (not array addition)
        }
        else // create empty list for the childless
            $descendant_list[$index] = array();
    }

    return $descendant_list;
}

function adi_menu_get_ancestors($section_list, $this_generation, $ancestor_list = array()) {
// find all ancestors of given section (in order: parent, grandparent, great-grandparent ...)

    $parent = $section_list[$this_generation]['adi_menu_parent'];
    if ($parent != '') {
        if (array_search($parent, $ancestor_list) !== FALSE) // loop found, so bomb out
            return $ancestor_list;
        $ancestor_list[] = $parent;
        return adi_menu_get_ancestors($section_list, $parent, $ancestor_list);
    }
    else
        return $ancestor_list;
}

function adi_menu_find_ancestor($level) {
// find ancestor of current section
    global $descendant_list, $section_levels, $s, $adi_menu_debug;

    $found = '';

    foreach ($descendant_list as $index => $list) {
        $index == 'adi_menu_root' ? // special case
            $this_level = 0 :
            $this_level = $section_levels[$index];
        if (array_search($s, $list) !== FALSE) {
            if ($level == $this_level) {
                $found = $index;
            }
        }
    }

    return $found;
}

function adi_menu_find_descendant($level) {
// find descendant of current section at specified level
    global $descendant_list, $section_levels, $s;

    $found = array();

    foreach ($descendant_list[$s] as $descendant) {
        $this_level = $section_levels[$descendant];
        if ($level == $this_level) {
            $found[] = $descendant;
        }
    }

    return $found;
}

function adi_menu_cat_section_map($section_list) {
// generate list of categories & sections that redirect to them

    $cat_section_map = array();

    foreach ($section_list as $name => $section) {
        if ($section['adi_menu_redirect_category'])
            $cat_section_map[$section['adi_menu_redirect_category']][] = $name;
    }

    return $cat_section_map;
}

function adi_menu_active($index, $hierarchy, $active_section, $active_parent, $active_article) {
// determines whether current element should be active or not (but is pre-informed about active_section, active_parent, active_article)
//         in articles mode - lowest parent is parent of active article
//        in non-articles mode - lowest parent is parent of active section
    global $s, $c, $descendant_list, $active_ancestors, $pretext, $articles, $cat_section_map;

    if ($articles) { // articles part of menu structure
        $active_section = ($active_section && !$pretext['id']); // active section (but not if displaying article) BEWARE: resetting $active_section here
        $active_section_parent = ($active_parent && !$pretext['id'] && array_key_exists($s, $hierarchy[$index]['child'])); // parent section of active section (but not if displaying an article)
        $active_article_parent = ($active_parent && (strcasecmp($s, $index) == 0)); // parent of active article
        $active_section_ancestor = ($active_ancestors && (array_search($s, $descendant_list[$index]) !== FALSE)); // ancestor of active section
        $active_article_ancestor = ($active_ancestors && (array_search('article_'.$pretext['id'], $descendant_list[$index]) !== FALSE)); // ancestor of active article
        //TODO - category parent
        //TODO - category ancestor
        return $active_section || $active_section_parent || $active_article_parent || $active_section_ancestor || $active_article_ancestor || $active_article;
    }
    else { // don't care about articles
        $active_section_parent = ($active_parent && array_key_exists($s, $hierarchy[$index]['child'])); // parent section of active section (this seems to work for category sections too)
        $active_section_ancestor = ($active_ancestors && (array_search($s, $descendant_list[$index]) !== FALSE)); // ancestor of active section
        $active_category_ancestor = FALSE;
        if ($c) { // category page?
            if (isset($cat_section_map[$c])) { // category used as redirect in menu hierarchy?
                foreach ($cat_section_map[$c] as $section) { // see if we're an ancestor of any sections redirecting to category
                    $active_category_ancestor = ($active_ancestors && ($active_category_ancestor || (array_search($section, $descendant_list[$index]) !== FALSE))); // ancestor of active category
                }
            }
        }
        return $active_section || $active_section_parent || $active_section_ancestor || $active_category_ancestor;
    }
}

function adi_menu_is_current($this_section, $this_category = '', $debug = FALSE) {
// determine whether supplied section or catgeory ($is_section=FALSE) is current or not
// i.e. section = $s OR force_current attribute has supplied a match
    global $s, $c, $force_current;

    if ($debug) echo __FUNCTION__."(): s=$s, c=$c, this_section=$this_section, this_category=$this_category";

    $current = FALSE;

    if ($this_section)
        $current = $current || (strcasecmp($s, $this_section) == 0);

    if ($this_category)
        $current = $current || (strcasecmp($c, $this_category) == 0);

    if ($force_current) {
        if ($debug) echo ", force_current";
        if (isset($force_current[$this_section]))
            $current = $current || (array_search($s, $force_current[$this_section]) !== FALSE);
        if (isset($force_current[$this_category]))
            $current = $current || (array_search($c, $force_current[$this_category]) !== FALSE);
    }

    if ($debug) echo ", current=$current".br;

    return $current;
}

function adi_menu_markup($hierarchy, $level) {
// output <ul>/<li> markup from given $hierarchy
    global $prefs, $menu_id, $parent_class, $active_class, $s, $c, $class, $link_span, $list_id, $list_id_prefix, $active_li_class, $articles, $include_children, $active_parent, $list_span, $active_ancestors, $descendant_list, $first_class, $last_class, $list_prefix, $prefix_class, $suppress_url, $suppress_url_sections, $article_class, $pretext, $active_article_class, $speaking_block, $label, $labeltag, $label_class, $label_id, $current_children_only, $adi_menu_escape, $odd_even, $ignore_alt_title, $adi_menu_vs_prefix, $exclude_niblings, $parent_link_class, $sub_menu_class, $sub_menu_link_class;

    $out = array();

    if (empty($hierarchy))
        return $out; // bomb out if hierarchy is empty

    $ul_id = $ul_classes = '';
    if (!$level) { // set HTML ID & CSS class on top level <ul> only
        if ($menu_id) $ul_id = ' id="'.$menu_id.'"';
        if ($class) $ul_classes .= $class;
        if ($label)
            $labeltag ?
                $out[] = doTag($label, $labeltag, $label_class, '', $label_id) :
                $out[] = $label;
    }
    // add submenu ul class (e.g. dropdown-menu)
    if ($level && $sub_menu_class)
        $ul_classes .= $sub_menu_class;

    $class_attr = ($ul_classes ? ' class="'.trim($ul_classes).'"' : '');
    $out[] = '<ul'.$ul_id.$class_attr.'>';

    // get list of section names from $hierarchy and determine first & last
    $keys = array_keys($hierarchy);
    $first_section = reset($keys);
    $last_section = end($keys);

    $odd = FALSE;
    foreach ($hierarchy as $section => $data) {
        $odd = !$odd;
        $parent = !empty($data['child']);
        $li_classes = '';
        if ($parent && $include_children)  // not a parent if not including the children
            $li_classes .= ' '.$parent_class;
        $active_section = FALSE;
        $active_article = FALSE;
        if ($data['section']) {
            if ($data['redirect_category']) {
                $active_section = adi_menu_is_current($section, $data['redirect_category']); // redirected to current category?
            } else if (!$c) { // active section? (avoid false-positive - category page's section is "default")
                $active_section = adi_menu_is_current($section);
                if ($data['redirect_section']) // section redirected to active section?
                    $active_section = adi_menu_is_current($data['redirect_section']);
            }
        }
        else { // $section is an article!
            $li_classes .= ' '.$article_class;
            $article_id = preg_replace('/article_/', '', $section); // convert 'article_id#' to 'id#'
            $active_article = ($article_id == $pretext['id']); // is the article active?
        }
        if ($data['redirect_section'] || $data['redirect_link'] || $data['redirect_category']) // redirected (to section/link/category)
            $li_classes .= ' menu_redirect';
        if ($data['redirect_link']) // redirected to link
            $li_classes .= ' menu_ext_link';
        if ($data['redirect_category']) // redirected to category
            $li_classes .= ' menu_category';
        if ($data['virtual_section']) // virtual section
            $li_classes .= ' menu_virtual';
        $title = adi_menu_htmlentities($data['title'], $adi_menu_escape);
        if ($data['alt_title'] && !$ignore_alt_title) { // alternative title specified
            $li_classes .= ' menu_alt_title';
            $title = adi_menu_htmlentities($data['alt_title'], $adi_menu_escape);
        }
        $url = $data['url']; // although URL may get suppressed later ...
        $clone = $data['clone'];
        $first = ($section == $first_section) && $first_class; // only flag first section if required
        $last = ($section == $last_section) && $last_class; // only flag last section if required
        $link_content = ($link_span ? span($title) :  $title);
        if ($speaking_block)
            $link_content .= adi_menu_speaking_block($section, $data['redirect_section']);
        if ($clone) { // section/category is a clone
            $clone_suffix = '_clone'; // make ID unique
            $li_classes .= ' menu_clone';
        }
        else
            $clone_suffix = '';
        $li_id = ($list_id ? ' id="'.$list_id_prefix.$section.$clone_suffix.'"' : '');
        $active_li = $active_li_class && adi_menu_active($section, $hierarchy, $active_section, $active_parent, $active_article);
        if ($active_li)
            $li_classes .= ' '.$active_li_class;
        $article_list = '';
        if ($parent) // suppress URL on parents only
            switch ($suppress_url) {
                case 'all':
                    $url = '#';
                    break;
                case 'top':
                    if (!$level) $url = '#';
                    break;
                case 'active':
                    if ($active_section) $url = '#';
                    break;
                /*case 'section':
                    if ($parent) $url = '#'; break;
                case 'article':
                    if ($article_parent) $url = '#'; break;*/
                default:
                    /* do nothing */
                    break;
            }
        if ($suppress_url_sections) { // check list of suppression orders
            $suppressions = do_list($suppress_url_sections);
            if (array_search($section, $suppressions) !== FALSE) $url = '#'; // no link for you chummy
        }
        if ($first) $li_classes .= ' '.$first_class;
        if ($last) $li_classes .= ' '.$last_class;
        if ($odd_even) $li_classes .= ' '.(($odd) ? 'menu_odd' : 'menu_even');

        $class_attr = ($li_classes ? ' class="'.trim($li_classes).'"' : '');
        $out[] = '<li'.$li_id.$class_attr.'>';

        if ($list_span) $out[] = '<span>';
        if ($list_prefix) $out[] = span($list_prefix, 'class="'.$prefix_class.'"');

        $active_a = $active_class && adi_menu_active($section, $hierarchy, $active_section, $active_parent, $active_article);
        // <a> classes
        $a_classes = ($active_a ? $active_class : ''); // active class
        $a_classes .= ($parent ? ' '.$parent_link_class : ''); // add parent link class (e.g. dropdown-toggle)
        $a_classes .= ($level && !$parent ? ' '.$sub_menu_link_class : ''); // add child link class (e.g. dropdown-item)

        $class_attr = ($a_classes ? ' class="'.trim($a_classes).'"' : '');
        $out[] = href($link_content, $url, $class_attr);

        if ($list_span) $out[] = '</span>';

        // the fact that we're here means that siblings are already included, so now decide if kids should be sought out
        $find_the_kids = TRUE;
        if ($current_children_only) // only immediate children of active (i.e. no grandchildren or niblings)
//             $find_the_kids = $active_section || array_key_exists($s, $data['child']) || (array_search($s, $descendant_list[$section]) !== FALSE); // active section, parent of active, or ancestor of active
            $find_the_kids = $active_section || (array_search($s, $descendant_list[$section]) !== FALSE); // active section or ancestor of active
        if ($exclude_niblings) // all descendants of active (i.e. no niblings)
            $find_the_kids = $active_section || (array_search($s, $descendant_list[$section]) !== FALSE) || (array_search($section, $descendant_list[$s]) !== FALSE); // active section, ancestor of active or descendant of active
        if ($parent && $include_children && $find_the_kids) // find the kids (but only if include_children=1)
            $out = array_merge($out, adi_menu_markup($data['child'], $level+1));
        $out[] = "</li>";
    }

    $out[] = "</ul>";

    return $out;
}

function adi_menu_articles($section, $wraptag) {
// generate list of articles/markup using <txp:article_custom />
    global $s, $articles, $article_attr, $adi_menu_article_form, $section_article_list, $active_articles_only;

    if (@txpinterface != 'admin') { // articles not relevent in admin interface
        $allowed = array_search($section, $section_article_list) !== FALSE; // check if articles allowed
        if ($active_articles_only) // then only allow articles if section is active
            $allowed &= ($section == $s);
        if (!$allowed) return '';
        $article_attr == '' ?
            $attr = '' :
            $attr = ' '.$article_attr;
        $article_list = trim(parse('<txp:article_custom section="'.$section.'"'.$attr.' form="'.$adi_menu_article_form.'" />'));
        if ($article_list == "")
            return '';
        else // articles found
            if ($wraptag == "")
                return $article_list;
            else
                return tag($article_list, $wraptag, '');
    }
}

function adi_menu_array_subtract($array1, $array2) {
// values in array2 that are not in array1 are removed

    $new = array();
    $count1 = count($array1);
    $count2 = count($array2);
    foreach ($array1 as $index1 => $value1) {
        $found = FALSE;
        foreach ($array2 as $index2 => $value2) {
            $found = $value1 == $value2;
            if ($found) break;
        }
        $found ? $found = FALSE : $new[] = $value1;
    }

    return $new;
}

function adi_menu_htmlentities($string, $method) {
// escape supplied string using:
//     new:
//        "" = default: ENT_COMPAT,'UTF-8' (thanks ttr)
//     old:
//        "html" = htmlentities (ALL special characters translated)
//        "htmlspecial" htmlspecialchars (only & " ' < > translated)

    if ($method) { // use manual sledgehammer
        if ($method == 'html') $string = htmlentities($string);
        if ($method == 'htmlspecial') $string = htmlspecialchars($string);
    }
    else
        $string = htmlentities($string, ENT_COMPAT, 'UTF-8');

    return $string;
}

function adi_menu($atts) {
// the <txp:adi_menu /> tag
    global $prefs, $s, $pretext, $out, $menu_id, $parent_class, $active_class, $include_parent, $include_childless, $default_title, $default_first, $clone_title, $class, $link_span, $list_id, $list_id_prefix, $active_li_class, $articles, $article_attr, $section_article_list, $include_children, $active_parent, $active_articles_only, $list_span, $active_ancestors, $descendant_list, $first_class, $last_class, $list_prefix, $prefix_class, $suppress_url, $suppress_url_sections, $article_class, $article_position, $active_article_class, $article_sort, $section_levels, $speaking_block, $speaking_block_form, $label, $labeltag, $label_class, $label_id, $current_children_only, $adi_menu_escape, $adi_menu_prefs, $odd_even, $section_article_sort, $category_article_sort, $ignore_alt_title, $cat_section_map, $exclude_clone, $cat_article_sort, $cat_article_attr, $force_current, $include_top_level, $include_siblings, $current_descendants_only, $exclude_niblings, $relative_urls, $parent_link_class, $sub_menu_class, $sub_menu_link_class;

    extract(lAtts(array(
        'active_ancestors'         => '0',              // set active class on all ancestors of current section
        'active_articles_only'     => '',               // list articles in the current active section only
        'active_class'             => 'active_class',   // CSS class for current section (<a>)
        'active_li_class'          => '',               // CSS class for current section (<li>)
        'active_parent'            => '0',              // set active class on parent of current section
        'article_attr'             => '',               // comma separated list of additional article_custom attributes (section & category articles)
        'article_class'            => 'menu_article',   // CSS class on <li> containing article link
        'article_exclude'          => '',               // list of sections not to have articles
        'article_include'          => '',               // exclusive list of sections to have articles (default = all)
        'article_position'         => 'after',          // where to place articles: before, after or dovetail with sections
        'article_sort'             => 'Posted desc',    // article sort (sections & categories)
        'articles'                 => '0',              // include articles in menu
        'cat_article_attr'         => '',               // comma separated list of additional article_custom attributes (category articles only)
        'cat_article_exclude'      => '',               // list of categories not to have articles
        'cat_article_include'      => '',               // exclusive list of categories to have articles (default = all)
        'cat_article_sort'         => '',               // article sort (categories only)
        'class'                    => 'section_list',   // CSS class for top level <ul>
        'clone_title'              => 'Summary',        // default title of child clone **DEPRECATED**
        'current_children_only'    => '0',              // only output child sections/categories/articles of current section
        'current_descendants_only' => '0',              // ignore child sections/categories/articles which don't belong to current section or its decendants
        'exclude_niblings'         => '0',              // ignore child sections/categories/articles which don't belong to current section or its decendants SHOULD BE NIBLINGS/COUSINS
        'default_first'             => '1',              // section 'default' to be listed first
        'default_title'            => 'Home',           // title for 'default' section
        'escape'                   => '',               // escape HTML entities in section titles: "", "html", "htmlspecial" (default="" - htmlentities/ENT_COMPAT/UTF-8)
        'exclude_clone'            => '0',              // stop clone appearing
        'exclude'                  => '',               // list of sections to be excluded (over and above what's excluded in admin)
        'first_class'               => '',               // CSS class on first <li> of list
        'force_current'            => '',               // list of sections defining when they should be considered as "current" (sec1,sec2:sec3,sec4;sec5,sec6:sec7,sec8), use for virtuals redirecting to categories
        'ignore_alt_title'         => '0',              // choose to ignore the alternatve titles
        'include_childless'        => '0',              // output childless section
        'include_children'         => '1',              // output children as well as parents
        'include_current'          => '0',              // include the current section (used with sections="...")
        'include_default'          => '1',              // include 'default' section (more of a "don't exclude default" setting!)
        'include_parent'           => '1',              // output parent of included sections' children
        'include_siblings'         => '0',              // sections at same level (without children)
        'include_top_level'        => '0',              // include top level sections (without children)
        'label_class'              => 'menu_label',     // CSS class for label's tag
        'label_id'                 => '',               // HTML ID for label's tag
        'label'                    => '',               // label string to precede menu
        'labeltag'                 => '',               // tag to wrap around label
        'last_class'               => '',               // CSS class on last <li> of list
        'link_span'                => '0',              // <span> contents of link or not
        'list_id_prefix'           => 'menu_',          // <li> ID prefix
        'list_id'                  => '0',              // output <li> IDs or not
        'list_prefix'              => '',               // prefix added to menu list items
        'list_span'                => '0',              // <span> contents of <li> or not
        'menu_id'                  => 'mainmenu',       // CSS ID for top level <ul>
        'odd_even'                 => '0',              // CSS classes applied to odd/even list items
        'override_exclude'         => '',               // list of sections, excluded in admin, to be included
        'parent_class'             => 'menuparent',     // CSS class for parent <li>
        'prefix_class'             => 'menu_prefix',    // class added to <span> around prefixes
        'parent_link_class'        => '',               // CSS class for parent <a>
        'sub_menu_class'           => '',               // CSS class for parent <ul>
        'relative_urls'            => '0',              // urls without domain or http/s protocol
        'role'                     => 'navigation',     // ARIA role applied to wraptag
        'sections'                 => '',               // list of sections in menu (default = all)
        'sort'                     => 'adi_menu_sort',  // section sort (use '' for database order)
        'speaking_block_form'      => '',               // alternative form for speaking block
        'speaking_block'           => '0',              // enable <span>speaking ... block</span>
        'sub_menu_level'           => '0',              // the level of the submenu to output
        'sub_menu_link_class'      => '',               // class for all <a> in submenus
        'sub_menu'                 => '0',              // generate submenu of current section
        'suppress_url_sections'    => '',               // list of sections to get URL "#"
        'suppress_url'             => '0',              // set URL to "#" on section links
        'wraptag_class'            => 'menu_wrapper',   // class for wraptag
        'wraptag_id'               => '',               // id for wraptag
        'wraptag'                  => '',               // wrap a tag around <ul>
        'debug'                    => '0'
    ), $atts));

    if (!adi_menu_installed()) return "adi_menu not installed";

    // deprecated attributes
    if (isset($atts['clone_title'])) trigger_error(gTxt('deprecated_attribute', array('{name}' => 'clone_title')), E_USER_NOTICE);

    // tidy up supplied attribute values
    $children_only = 0; // ex-attribute
    if ($sub_menu_level == "1") // switch to standard mode
        $sub_menu_level = 0;

    // error page
    if ($sub_menu_level && !if_status(array(), TRUE)) { // submenus don't make sense on error pages
        if ($debug) echo "Submenu switched off on error page".br;
        return '';
    }

    // don't have to worry about escaping default title because it's stored in $section_list & processed later
    $clone_title = trim($clone_title);
    if (empty($clone_title)) // don't want it to be empty
        $clone_title = 'Summary';

    // menu item sort
    $sort = trim($sort); // MySQL error if sort = " "
    empty($sort) ? $sort = 'NULL' : $sort = doSlash($sort); // = database order by default

    // article sorting
    $fallback_sort = 'Posted desc';
    // section article sort
    empty($article_sort) ? $article_sort = 'NULL' : $article_sort = doSlash(trim($article_sort)); // set to NULL if article_sort="" supplied
    $article_sort_list = do_list($article_sort, ';'); // split article_sort "title;section1:posted desc;section2:custom_2"
    $section_article_sort = array(); // section specific sorting
    $default_sort = '';
    foreach ($article_sort_list as $this_sort) {
        $this_section_sort = do_list($this_sort, ':');
        if (count($this_section_sort) > 1) // e.g. "section1:posted desc"
            $section_article_sort[$this_section_sort[0]] = doSlash($this_section_sort[1]);
        else // e.g. "title; ..."
            if ($this_sort)
                $default_sort = doSlash($this_sort);
            else // e.g. ";section1:title ..."
                $default_sort = 'NULL';
    }
    empty($default_sort) ? $article_sort = doSlash($fallback_sort) : $article_sort = $default_sort; // $article_sort is default section sort, $section_article_sort contains category specific sorts
    // category article sort
    empty($cat_article_sort) ? $cat_article_sort = $article_sort : $cat_article_sort = doSlash(trim($cat_article_sort)); // if not supplied, cat_article_sort follows article_sort
    $cat_article_sort_list = do_list($cat_article_sort, ';'); // split cat_article_sort "title;cat1:posted desc;cat2:custom_2"
    $category_article_sort = array(); // category specific sorting
    $default_sort = '';
    foreach ($cat_article_sort_list as $this_sort) {
        $this_category_sort = do_list($this_sort, ':');
        if (count($this_category_sort) > 1) // e.g. "cat1:posted desc"
            $category_article_sort[$this_category_sort[0]] = doSlash($this_category_sort[1]);
        else // e.g. "title; ..."
            if ($this_sort)
                $default_sort = doSlash($this_sort);
            else // e.g. ";cat1:title ..."
                $default_sort = 'NULL';
    }
    empty($default_sort) ? $cat_article_sort = $article_sort : $cat_article_sort = $default_sort; // $cat_article_sort is default category specific, $cat_article_sort contains category specific sorts

    // article attributes
    if (trim($cat_article_attr) == '') // if not supplied, cat_article_attr follows article_attr
        $cat_article_attr = $article_attr;

    // seem to recall this is required to avoid interference from adi_menu_breadcrumb escape attribute ??? FIXED BY new a_m_breadcrumb code?
    $adi_menu_escape = $escape;

    // massage sections list
    if ($sub_menu_level) // make sure currently active section IS included e.g. when section normally excluded from main menu but a submenu is required on it's own (separately linked-to) page
        $include_current = 1;
    if ($include_current) // add current section to list
        empty($sections) ? $sections = $s : $sections = $sections.",$s";
    // section-sensitive current-level-specific submenu
    if ($sub_menu) { // override sections list with current section
        $sections = $s;
        $children_only = 1;
    }

    // fiddle with default
    if (!$include_default) // add default to exclude list
        empty($exclude) ? $exclude = "default" : $exclude .= ",default";

    // get bulk section info from database (using $sections & $exclude attributes)
    $section_list = adi_menu_section_list($sections, $exclude, $override_exclude, $sort);

    // make up list of siblings
    $siblings = adi_menu_siblings($section_list);

    // include list (used by prune later)
    $include_list = array();
    if (!empty($sections)) // specific sections (& hence their children) selected
        $include_list = do_list($sections); // trim spaces around section names in array

    // dark forces
    if ($force_current) {
        // force_current="sec1,sec2:sec3,sec4; sec5,sec6:sec7,sec8" - sec1 or sec2 considered current if sec3 or sec4 are current
        // generate array indexed by section => array of current sections (when to be considered current itself)
        $force_lists = do_list($force_current, ';'); // (sec1,sec2:sec3,sec4) (sec5,sec6:sec7,sec8)
        $force_current = array();
        foreach ($force_lists as $force) {
            $forced = do_list($force,':'); // (sec1,sec2) (sec3,sec4)
            if (count($forced) == 2) {
                $f1 = do_list($forced[0]); // (sec1,sec2)
                $f2 = do_list($forced[1]); // (sec3,sec4)
                if ($forced[1])
                    foreach ($f1 as $section)
                        $force_current[$section] = $f2; // sec1 -> (sec3,sec4)
            }
        }
    }

    // do articles bit
    $article_list = $cat_article_list = array();
    if ($articles) {
        // SECTIONS
        // sections that are allowed articles
        if (empty($article_include))
            $section_article_include = array_keys($section_list); // all sections
        else
            $section_article_include = do_list($article_include);
        // sections that are NOT allowed articles
        if (empty($article_exclude))
            $section_article_exclude = array();
        else
            $section_article_exclude = do_list($article_exclude);
        // section_article_list = section_article_include minus section_article_exclude
        $section_article_list = adi_menu_array_subtract($section_article_include, $section_article_exclude);
        $article_list = adi_menu_get_articles($section_list, $section_article_list, array(), $debug);
        // CATEGORIES
        // categories that are allowed articles
        $category_list = safe_column('name', 'txp_category', "name != 'root' AND type='article'");
        if (empty($cat_article_include))
            $category_article_include = array_keys($category_list); // all categories
        else
            $category_article_include = do_list($cat_article_include);
        // categories that are NOT allowed articles
        if (empty($cat_article_exclude))
            $category_article_exclude = array();
        else
            $category_article_exclude = do_list($cat_article_exclude);
        // category_article_list = category_article_include minus category_article_exclude
        $category_article_list = adi_menu_array_subtract($category_article_include, $category_article_exclude);
        $cat_article_list = adi_menu_get_articles($section_list, array(), $category_article_list, $debug);
    }

    // set up hierarchy
    $hierarchy = $original_hierarchy = adi_menu_hierarchy($section_list, $article_list, $cat_article_list);

    // descendant list
    $descendant_list = array();
    $descendant_list = adi_menu_descendants($hierarchy, 'adi_menu_root');

    // sub or normal menu?
    $section_levels = adi_menu_section_levels($hierarchy);
    if ($sub_menu_level) { // set up a new include list for level-specific submenus
        $include_list = array();
        $ancestor = adi_menu_find_ancestor($sub_menu_level);
        $descendants = adi_menu_find_descendant($sub_menu_level);
        $this_section = $s; // don't want to muck with $s
        if (empty($this_section)) $this_section = 'default'; // to cope with error page (thanks CeBe)
        // submenu scenarios
        if ($section_levels[$this_section] == $sub_menu_level) { // ONE: current section at required level
            $include_list[] = $section_list[$this_section]['adi_menu_parent']; // add current's parent to list to get siblings
            $children_only = "1"; // but don't want current section's parent itself
            if ($debug) echo "Submenu scenario ONE".br.br;
        }
        else if ($section_levels[$this_section] == ($sub_menu_level - 1)) { // TWO: current sections' children at required level
            $include_list[] = $this_section; // add current section to list to get children
            $children_only = "1"; // but don't want current section itself
            if ($debug) echo "Submenu scenario TWO".br.br;
        }
        else if ($ancestor) { // THREE: there're ancestors at required level
                // add ancestor's parent to list to get siblings
                $include_list[] = $section_list[adi_menu_find_ancestor($sub_menu_level)]['adi_menu_parent'];
                $children_only = "1"; // don't want ancestor's parent itself
            if ($debug) echo "Submenu scenario THREE".br.br;
        }
        // FOUR: descendants (beyond immediate children) at right level
        else if ($descendants) {
            foreach ($descendants as $descendant)
                $include_list[] = $section_list[$descendant]['adi_menu_parent']; // add each descendant's parent to list to get children (multiple descendants may be siblings or cousins)
            $children_only = "1"; // but don't want current section's parent itself
            if ($debug) echo "Submenu scenario FOUR".br.br;
        }
        else { // FIVE: can't find anything at requested level, so kill the menu
            $hierarchy = array();
            if ($debug) echo "Submenu scenario FIVE".br.br;
        }
    }
    else // normal menu
        if (empty($sections) && !$include_parent) // make up list of top level sections (& cater for old submenu mode)
            $include_list = array_keys($hierarchy); // all top level sections

    // prune hierarchy
    if ($include_list) {
        if ($children_only) $include_parent = "0"; // OLD SUBMENU?
        $hierarchy = adi_menu_prune($hierarchy, $include_list, $section_levels, $siblings);
    }

    //??? TEST ON LOWER LEVELS - NO COZ LOSING THIS
    if ($current_descendants_only)
        $hierarchy = adi_menu_prune($hierarchy, array($s), $section_levels, $siblings);

    // map sections to categories
    $cat_section_map = adi_menu_cat_section_map($section_list);

    // DEBUG
    if ($debug) {
        echo "SECTION INCLUDE LIST (all if empty):".br;
        dmp($include_list);
        echo "SECTION EXCLUDE LIST (none if empty):".br;
        echo $exclude.br.br;
        echo "SECTION LIST:";
        dmp($section_list);
        if ($articles) {
            echo "SECTION ARTICLE INCLUDE LIST:";
            dmp($section_article_include);
            echo "SECTION ARTICLE EXCLUDE LIST:";
            dmp($section_article_exclude);
            echo "SECTION ARTICLE LIST (include minus exclude):";
            dmp($section_article_list);
            echo "CATEGORY ARTICLE INCLUDE LIST:";
            dmp($category_article_include);
            echo "CATEGORY ARTICLE EXCLUDE LIST:";
            dmp($category_article_exclude);
            echo "CATEGORY ARTICLE LIST (include minus exclude):";
            dmp($category_article_list);
            echo "ARTICLE LIST (by section):";
            dmp($article_list);
            echo "ARTICLE LIST (by category):";
            dmp($cat_article_list);
        }
        else
            echo '(ARTICLE MODE NOT SELECTED)'.br.br;
        echo 'SECTION ARTICLE SORT (default='.$article_sort.'):';
        dmp($section_article_sort);
        echo 'CATEGORY ARTICLE SORT (default='.$cat_article_sort.'):';
        dmp($category_article_sort);
        echo "ORIGINAL HIERARCHY:";
        dmp($original_hierarchy);
        if (isset($include_list)) {
            echo "PRUNED HIERARCHY:";
            dmp($hierarchy);
        }
        else
            echo '(HIERARCHY NOT PRUNED)'.br.br;
        if (isset($section_levels)) {
            echo "SECTION LEVELS:";
            dmp($section_levels);
        }
        echo "DESCENDANT LIST:";
        dmp($descendant_list);
        if (isset($siblings)) {
            echo "SIBLINGS:";
            dmp($siblings);
        }
        echo 'CATEGORY-SECTION MAP:';
        $cat_section_map = adi_menu_cat_section_map($section_list);
        dmp($cat_section_map);
        echo "FORCE CURRENT MAPPING:";
        dmp($force_current);
        echo "VARIOUS:".br;
        echo "Current section (\$s) = $s".br;
        echo "Current section's level = $section_levels[$s]".br;
        echo "Submenu level = $sub_menu_level".br;
        echo "Current article id = ".$pretext['id']."".br;
        echo "Articles = $articles".br;
        $page_status = !empty($GLOBALS['txp_error_code']) ? $GLOBALS['txp_error_code'] : $pretext['status'];
        echo "Page status: $page_status";
        echo if_status(array(), TRUE) ? " (Normal page)".br : " (Error page)".br;
        echo br."SUPPLIED ATTRIBUTES:";
        dmp($atts);
        echo "ARTICLE ATTRIBUTES:";
        dmp(adi_menu_get_article_attr($article_attr));
        echo "CATEGORY ARTICLE ATTRIBUTES:";
        dmp(adi_menu_get_article_attr($cat_article_attr));
        if ($adi_menu_prefs) { // admin interface only
            echo "PREFS".br;
            foreach ($adi_menu_prefs as $name => $value)
                echo $name.': '.adi_menu_prefs($name).br;
        }
    }

    // HTML5 awareness
    $role = '';
    if (isset($prefs['doctype']))
        if ($prefs['doctype'] == 'html5') {
            if ($wraptag && $role)
                $role = ' role="'.$role.'"';
        }

    // generate markup
    $out = adi_menu_markup($hierarchy, 0);
    $out = trim(implode($out));
    if ($out && $wraptag) { // add wraptag stuff
        $wrap_attr = '';
        if ($wraptag_id) $wrap_attr .= ' id="'.$wraptag_id.'"';
        if ($wraptag_class) $wrap_attr .= ' class="'.$wraptag_class.'"';
        $wrap_attr .= $role;
        $out = tag($out, $wraptag, $wrap_attr);
    }

    // output markup
    return $out;
}
