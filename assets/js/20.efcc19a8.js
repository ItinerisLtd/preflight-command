(window.webpackJsonp=window.webpackJsonp||[]).push([[20],{177:function(t,s,e){"use strict";e.r(s);var a=e(0),n=Object(a.a)({},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"content"},[t._m(0),t._v(" "),t._m(1),t._v(" "),t._m(2),t._v(" "),t._m(3),t._v(" "),t._m(4),t._m(5),t._v(" "),t._m(6),e("p",[t._v("Not everyone has an Airbus A380, printing the report in yaml works better on smaller screens.")]),t._v(" "),t._m(7),e("p",[t._v("To see all available options:")]),t._v(" "),t._m(8),t._m(9),t._v(" "),e("p",[t._v("Lists all registered "),e("router-link",{attrs:{to:"./../checkers/"}},[t._v("checkers")]),t._v(" (without running them).")],1),t._v(" "),t._m(10),t._m(11),t._v(" "),t._m(12),t._v(" "),t._m(13),e("p",[t._v("Learn more about "),e("router-link",{attrs:{to:"./../config/"}},[t._v("config files")]),t._v(".")],1),t._v(" "),t._m(14),t._v(" "),t._m(15)])},[function(){var t=this.$createElement,s=this._self._c||t;return s("h1",{attrs:{id:"commands"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#commands","aria-hidden":"true"}},[this._v("#")]),this._v(" Commands")])},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"tip custom-block"},[e("p",{staticClass:"custom-block-title"},[t._v("THERE ARE MORE")]),t._v(" "),e("p",[t._v("This page only shows a handful of basic usages. The "),e("code",[t._v("help")]),t._v(" command is your friend:")]),t._v(" "),e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[t._v("$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight\n\n"),e("span",{attrs:{class:"token comment"}},[t._v("# even more details")]),t._v("\n"),e("span",{attrs:{class:"token comment"}},[t._v("# wp help preflight <command>")]),t._v("\n"),e("span",{attrs:{class:"token comment"}},[t._v("# wp help preflight <command> <subcommand>")]),t._v("\n$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight check\n$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight config\n$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight config paths\n$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight config validate\n$ wp "),e("span",{attrs:{class:"token function"}},[t._v("help")]),t._v(" preflight checklist\n")])])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("h2",{attrs:{id:"wp-preflight-check"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#wp-preflight-check","aria-hidden":"true"}},[this._v("#")]),this._v(" $ wp preflight check")])},function(){var t=this.$createElement,s=this._self._c||t;return s("p",[this._v("This command runs all the registered checkers and prints a report. Your goal is to get "),s("code",[this._v("Success")]),this._v(" on all checks.")])},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[t._v("$ wp preflight check\n+-------------------------------------+----------+\n"),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" "),e("span",{attrs:{class:"token function"}},[t._v("id")]),t._v("                                  "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" status   "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v("\n+-------------------------------------+----------+\n"),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" allow-indexing                      "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" Success  "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v("\n"),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" outdated-packages                   "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" Failure  "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v("\n"),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" required-salt-constants             "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" Error    "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v("\n"),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" secure-home-url                     "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v(" Disabled "),e("span",{attrs:{class:"token operator"}},[t._v("|")]),t._v("\n+-------------------------------------+----------+\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("p",[this._v("Get more details with the "),s("code",[this._v("message")]),this._v(" field when you encounter an "),s("code",[this._v("Error")]),this._v(" or "),s("code",[this._v("Failure")]),this._v(".")])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"language-bash extra-class"},[s("pre",{pre:!0,attrs:{class:"language-bash"}},[s("code",[this._v("$ wp preflight check --fields"),s("span",{attrs:{class:"token operator"}},[this._v("=")]),this._v("id,status,message\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"language-bash extra-class"},[s("pre",{pre:!0,attrs:{class:"language-bash"}},[s("code",[this._v("$ wp preflight check --fields"),s("span",{attrs:{class:"token operator"}},[this._v("=")]),this._v("id,description,link,status,messages --format"),s("span",{attrs:{class:"token operator"}},[this._v("=")]),this._v("yaml\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"language-bash extra-class"},[s("pre",{pre:!0,attrs:{class:"language-bash"}},[s("code",[this._v("$ wp "),s("span",{attrs:{class:"token function"}},[this._v("help")]),this._v(" preflight check\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("h2",{attrs:{id:"wp-preflight-checklist"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#wp-preflight-checklist","aria-hidden":"true"}},[this._v("#")]),this._v(" $ wp preflight checklist")])},function(){var t=this.$createElement,s=this._self._c||t;return s("div",{staticClass:"language-bash extra-class"},[s("pre",{pre:!0,attrs:{class:"language-bash"}},[s("code",[this._v("$ wp preflight checklist\n\n"),s("span",{attrs:{class:"token comment"}},[this._v("# in yaml format, for smaller screens")]),this._v("\n$ wp preflight checklist --format"),s("span",{attrs:{class:"token operator"}},[this._v("=")]),this._v("yaml\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("h2",{attrs:{id:"wp-preflight-config"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#wp-preflight-config","aria-hidden":"true"}},[this._v("#")]),this._v(" $ wp preflight config")])},function(){var t=this.$createElement,s=this._self._c||t;return s("p",[this._v("Reads and validates all the "),s("code",[this._v("preflight.toml")]),this._v(" config files including the packages ones (i.e: the default config).")])},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[e("span",{attrs:{class:"token comment"}},[t._v("# print the content of all config files")]),t._v("\n$ wp preflight config "),e("span",{attrs:{class:"token function"}},[t._v("cat")]),t._v("\n\n"),e("span",{attrs:{class:"token comment"}},[t._v("# get the paths to all config files")]),t._v("\n$ wp preflight config paths\n\n"),e("span",{attrs:{class:"token comment"}},[t._v("# validate the TOML syntax")]),t._v("\n$ wp preflight config validate\n")])])])},function(){var t=this.$createElement,s=this._self._c||t;return s("h2",{attrs:{id:"misc"}},[s("a",{staticClass:"header-anchor",attrs:{href:"#misc","aria-hidden":"true"}},[this._v("#")]),this._v(" Misc")])},function(){var t=this,s=t.$createElement,e=t._self._c||s;return e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[e("span",{attrs:{class:"token comment"}},[t._v("# install, `:@stable` is important")]),t._v("\n$ wp package "),e("span",{attrs:{class:"token function"}},[t._v("install")]),t._v(" itinerisltd/preflight-command:@stable\n\n"),e("span",{attrs:{class:"token comment"}},[t._v("# install more checkers")]),t._v("\n"),e("span",{attrs:{class:"token comment"}},[t._v("# you might not need them all, check their documents")]),t._v("\n$ wp package "),e("span",{attrs:{class:"token function"}},[t._v("install")]),t._v(" itinerisltd/preflight-extra:@stable\n$ wp package "),e("span",{attrs:{class:"token function"}},[t._v("install")]),t._v(" itinerisltd/preflight-yoast-seo:@stable\n\n"),e("span",{attrs:{class:"token comment"}},[t._v("# update")]),t._v("\n$ wp package update\n")])])])}],!1,null,null,null);n.options.__file="README.md";s.default=n.exports}}]);