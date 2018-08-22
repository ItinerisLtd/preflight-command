(window.webpackJsonp=window.webpackJsonp||[]).push([[21],{184:function(t,e,s){"use strict";s.r(e);var a=s(0),n=Object(a.a)({},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"content"},[t._m(0),t._v(" "),s("div",{staticClass:"warning custom-block"},[s("p",{staticClass:"custom-block-title"},[t._v("WARNING")]),t._v(" "),s("p",[t._v("Use TOML "),s("a",{attrs:{href:"https://github.com/toml-lang/toml/blob/master/versions/en/toml-v0.4.0.md",target:"_blank",rel:"noopener noreferrer"}},[t._v("v0.4.0 syntax"),s("OutboundLink")],1),t._v(" only.")]),t._v(" "),s("p",[t._v("TOML v0.5.0 not yet supported.")])]),t._v(" "),t._m(1),t._v(" "),s("p",[t._v("Although the package comes with a "),s("a",{attrs:{href:"https://github.com/ItinerisLtd/preflight-command/tree/master/config",target:"_blank",rel:"noopener noreferrer"}},[t._v("sane default configuration"),s("OutboundLink")],1),t._v(", nothing stops you from customizing it for your specific needs.")]),t._v(" "),t._m(2),t._v(" "),t._m(3),s("p",[t._v("Learn more about "),s("router-link",{attrs:{to:"./../checkers/"}},[t._v("checker configuration")]),t._v(".")],1),t._v(" "),t._m(4),t._v(" "),t._m(5),t._v(" "),t._m(6),t._m(7),t._v(" "),t._m(8),t._v(" "),s("p",[t._v("For "),s("a",{attrs:{href:"https://github.com/root/bedrock/",target:"_blank",rel:"noopener noreferrer"}},[t._v("Bedrock"),s("OutboundLink")],1),t._v(" or other custom WordPress structures, which not suitable for adding config files under "),s("code",[t._v("ABSPATH")]),t._v(". You can use "),s("code",[t._v("PREFLIGHT_DIR")]),t._v(" to define an alternative path.")]),t._v(" "),t._m(9),t._m(10),t._v(" "),t._m(11),t._v(" "),t._m(12),t._m(13),t._v(" "),s("p",[t._v("Key Points:")]),t._v(" "),t._m(14),t._v(" "),s("p",[t._v("Learn more about TOML on its "),s("a",{attrs:{href:"https://github.com/toml-lang/toml",target:"_blank",rel:"noopener noreferrer"}},[t._v("GitHub repo"),s("OutboundLink")],1),t._v(".")]),t._v(" "),t._m(15),t._v(" "),t._m(16),t._v(" "),s("p",[t._v("Worry not. We check your config files as well.")]),t._v(" "),t._m(17)])},[function(){var t=this.$createElement,e=this._self._c||t;return e("h1",{attrs:{id:"config"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#config","aria-hidden":"true"}},[this._v("#")]),this._v(" Config")])},function(){var t=this.$createElement,e=this._self._c||t;return e("h2",{attrs:{id:"preflight-toml"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#preflight-toml","aria-hidden":"true"}},[this._v("#")]),this._v(" preflight.toml")])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[this._v("A "),e("code",[this._v("preflight.toml")]),this._v(" looks like this:")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"language-toml extra-class"},[e("pre",{pre:!0,attrs:{class:"language-text"}},[e("code",[this._v("[my-checker-id-1]\nenabled = false\n\n[my-checker-id-2]\nblacklist = [\n  'bad-1',\n  'bad-2',\n]\nwhitelist = [\n  'remove-me-from-blacklist',\n]\n\n[my-checker-id-3]\nincludes = [\n  'must-have-1',\n  'must-have-2',\n]\nexcludes = [\n  'remove-me-from-includes',\n]\n")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("h2",{attrs:{id:"where-to-put-preflight-toml"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#where-to-put-preflight-toml","aria-hidden":"true"}},[this._v("#")]),this._v(" Where to put "),e("code",[this._v("preflight.toml")]),this._v("?")])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[this._v("By default, the package looks for "),e("code",[this._v("preflight.toml")]),this._v(" under "),e("code",[this._v("ABSPATH")]),this._v(", usually this mean same level with "),e("code",[this._v("wp-config.php")]),this._v(".")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"language- extra-class"},[e("pre",{pre:!0,attrs:{class:"language-text"}},[e("code",[this._v("/my/htdocs/wordpress\n├── ...\n├── preflight.toml\n└── wp-config.php\n")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("h3",{attrs:{id:"preflight-dir"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#preflight-dir","aria-hidden":"true"}},[this._v("#")]),this._v(" PREFLIGHT_DIR")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"tip custom-block"},[s("p",{staticClass:"custom-block-title"},[t._v("NOTE")]),t._v(" "),s("p",[t._v("If "),s("code",[t._v("preflight.toml")]),t._v(" were found under both "),s("code",[t._v("ABSPATH")]),t._v(" and "),s("code",[t._v("PREFLIGHT_DIR")]),t._v(" at the same time, the "),s("code",[t._v("PREFLIGHT_DIR")]),t._v(" one has higher priority.")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"language-php extra-class"},[s("pre",{pre:!0,attrs:{class:"language-php"}},[s("code",[s("span",{attrs:{class:"token function"}},[t._v("define")]),s("span",{attrs:{class:"token punctuation"}},[t._v("(")]),s("span",{attrs:{class:"token single-quoted-string string"}},[t._v("'PREFLIGHT_DIR'")]),s("span",{attrs:{class:"token punctuation"}},[t._v(",")]),t._v(" "),s("span",{attrs:{class:"token single-quoted-string string"}},[t._v("'/my/absolute/path'")]),s("span",{attrs:{class:"token punctuation"}},[t._v(")")]),s("span",{attrs:{class:"token punctuation"}},[t._v(";")]),t._v("\n")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("p",[this._v("The package looks for "),e("code",[this._v("/my/absolute/path/preflight.toml")]),this._v(".")])},function(){var t=this.$createElement,e=this._self._c||t;return e("h2",{attrs:{id:"wp-preflight-config-paths"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#wp-preflight-config-paths","aria-hidden":"true"}},[this._v("#")]),this._v(" $ wp preflight config paths")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"language-bash extra-class"},[e("pre",{pre:!0,attrs:{class:"language-bash"}},[e("code",[e("span",{attrs:{class:"token comment"}},[this._v("# get the paths to all config files")]),this._v("\n$ wp preflight config paths\nSuccess: 3 config files found.\nSuccess: The later ones override any previous configurations.\n/root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml\n/app/public/preflight.toml\n/app/preflight.toml\n")])])])},function(){var t=this.$createElement,e=this._self._c||t;return e("h2",{attrs:{id:"toml"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#toml","aria-hidden":"true"}},[this._v("#")]),this._v(" TOML")])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("ul",[s("li",[t._v("file extension is "),s("code",[t._v(".toml")]),t._v(" (e.g: "),s("code",[t._v("preflight.toml")]),t._v(")")]),t._v(" "),s("li",[t._v("TOML is case sensitive")]),t._v(" "),s("li",[t._v("empty array is invalid")]),t._v(" "),s("li",[t._v("indentation doesn't matter")]),t._v(" "),s("li",[t._v("tabs or spaces doesn't matter")])])},function(){var t=this.$createElement,e=this._self._c||t;return e("h2",{attrs:{id:"wp-preflight-config-validate"}},[e("a",{staticClass:"header-anchor",attrs:{href:"#wp-preflight-config-validate","aria-hidden":"true"}},[this._v("#")]),this._v(" $ wp preflight config validate")])},function(){var t=this.$createElement,e=this._self._c||t;return e("div",{staticClass:"tip custom-block"},[e("p",{staticClass:"custom-block-title"},[this._v("NOTE")]),this._v(" "),e("p",[this._v("Any invalid TOML files are ignored through out the package.")]),this._v(" "),e("p",[this._v("Empty and comment-only files are considered as valid.")])])},function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("div",{staticClass:"language-bash extra-class"},[s("pre",{pre:!0,attrs:{class:"language-bash"}},[s("code",[s("span",{attrs:{class:"token comment"}},[t._v("# validate all the config files including the package default ones")]),t._v("\n$ wp preflight config validate\n"),s("span",{attrs:{class:"token operator"}},[t._v("==")]),s("span",{attrs:{class:"token operator"}},[t._v("==")]),s("span",{attrs:{class:"token operator"}},[t._v(">")]),t._v(" Validating /root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml\nSuccess: File "),s("span",{attrs:{class:"token string"}},[t._v("'/root/.wp-cli/packages/vendor/itinerisltd/preflight-command/config/default.toml'")]),t._v(" is valid.\n\n"),s("span",{attrs:{class:"token operator"}},[t._v("==")]),s("span",{attrs:{class:"token operator"}},[t._v("==")]),s("span",{attrs:{class:"token operator"}},[t._v(">")]),t._v(" Validating /app/public/preflight.toml\n\n  Syntax error: unexpected token "),s("span",{attrs:{class:"token string"}},[t._v('"T_NEWLINE"')]),t._v(" at line 2 with value "),s("span",{attrs:{class:"token string"}},[t._v('""')]),s("span",{attrs:{class:"token keyword"}},[t._v(".")]),t._v(" Expected "),s("span",{attrs:{class:"token string"}},[t._v('"T_RIGHT_SQUARE_BRAKET"')]),t._v(" "),s("span",{attrs:{class:"token keyword"}},[t._v("in")]),t._v(" "),s("span",{attrs:{class:"token string"}},[t._v('"\\/app\\/public\\/preflight.toml"')]),s("span",{attrs:{class:"token keyword"}},[t._v(".")]),t._v("\n\nWarning: File "),s("span",{attrs:{class:"token string"}},[t._v("'/app/public/preflight.toml'")]),t._v(" will be ignored.\n")])])])}],!1,null,null,null);n.options.__file="README.md";e.default=n.exports}}]);