!function(a){a.fn.smart_dom_button=function(b){var c=a.extend({debug:!1,action_attribute:"action_attribute",response_container:"response_container",ajax_action:"action",label_attributes:{process:"processing_label",revert_label:"revert_label",verify_action:"verify_action"}},b);return log=function(a,b){c.debug&&window.console&&console.debug&&("error"==b?console.error(a):console.log(a))},get_label=function(b){var c=a(b).get(0).tagName,d="";switch(c){case"SPAN":d=a(b).text();break;case"INPUT":d=a(b).val()}return d},set_label=function(b,c){switch(c.type){case"SPAN":a(c.button).text(b);break;case"INPUT":a(c.button).val(b)}return b},do_execute=function(b){var d={button:b,type:a(b).get(0).tagName,original_label:a(b).attr("original_label")?a(b).attr("original_label"):get_label(b)};c.wrapper&&a(d.button).closest(c.wrapper).length?(d.wrapper=a(d.button).closest(c.wrapper),d.use_wrapper=!0):(d.wrapper=d.button,d.use_wrapper=!1),d.the_action=a(d.wrapper).attr(c.action_attribute)?a(d.wrapper).attr(c.action_attribute):!1,c.label_attributes.processing&&a(d.wrapper).attr(c.label_attributes.processing)&&(d.processing_label=a(d.wrapper).attr(c.label_attributes.processing)?a(d.wrapper).attr(c.label_attributes.processing):!1),c.label_attributes.verify_action&&a(d.wrapper).attr(c.label_attributes.verify_action)&&(d.verify_action=a(d.wrapper).attr(c.label_attributes.verify_action)?a(d.wrapper).attr(c.label_attributes.verify_action):!1),c.label_attributes.revert_label&&a(d.wrapper).attr(c.label_attributes.revert_label)&&(d.revert_label=a(d.wrapper).attr(c.label_attributes.revert_label)?a(d.wrapper).attr(c.label_attributes.revert_label):!1,a(d.wrapper).attr("original_label")||(d.original_label=get_label(d.button),a(d.wrapper).attr("original_label",d.original_label))),d.the_action&&(!d.verify_action||confirm(d.verify_action))&&(d.use_wrapper&&(a(c.response_container,d.wrapper).length||a(d.wrapper).append('<span class="response_container"></span>'),d.response_container=a(".response_container",d.wrapper),a(d.response_container).removeClass(),a(d.response_container).addClass("response_container"),d.processing_label&&a(d.response_container).html(d.processing_label)),"ui"==d.the_action?(d.revert_label&&(get_label(d.button)==d.revert_label?set_label(d.original_label,d):set_label(d.revert_label,d)),a(d.wrapper).attr("toggle")&&a(a(d.wrapper).attr("toggle")).toggle(),a(d.wrapper).attr("show")&&a(a(d.wrapper).attr("show")).show(),a(d.wrapper).attr("hide")&&a(a(d.wrapper).attr("hide")).hide()):a.post(ajaxurl,{action:c.ajax_action,the_action:d.the_action},function(b){if(b&&b.success){a(d.response_container).show(),b.css_class&&a(d.response_container).addClass(b.css_class),b.remove_element&&a(b.remove_element).length&&a(b.remove_element).remove(),a(d.response_container).html(b.message);var c;a(d.response_container).mouseover(function(){c=setTimeout(function(){a(d.response_container).fadeOut("slow",function(){a(d.response_container).remove()})},1e4)}).mouseout(function(){clearTimeout(c)})}},"json"))},a(this).click(function(){log("Button triggered."),do_execute(this)}),this}}(jQuery);