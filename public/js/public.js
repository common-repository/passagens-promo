!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=0)}([function(t,n){var o,r=["Jan","Fev","Mar","Abr","Mai","Jun","Jul","Ago","Set","Out","Nov","Dez"],a=passagens_promo.page_width,s=!0,i="";""!=p(o="ppromo_last_origin")&&null!=p(o)&&document.querySelectorAll(".ppromo-origin-filter").forEach((function(e){var t=e.parentNode.parentNode.parentNode.getAttribute("data-shortcode"),n=e.parentNode.parentNode.parentNode.getAttribute("data-utm-params");""!=t&&null!=t&&void 0!==t&&(l(t=t.replace("##","@"+p("ppromo_last_origin")),e,n),function(e,t){for(var n,o=e.options,r=0;n=o[r];r++)if(n.value==t){e.selectedIndex=r;break}}(e,p("ppromo_last_origin")))}));var c=function(){var t=window.innerWidth>768?"desktop":"mobile";if(s=i!==t,i=t,s){var n=document.getElementsByClassName("passagens-promo"),o=!0,r=!1,c=void 0;try{for(var l,p=n[Symbol.iterator]();!(o=(l=p.next()).done);o=!0)e=l.value,e.clientWidth<430?(e.firstElementChild.classList.remove("comp-newshortcode--mod01"),e.firstElementChild.classList.remove("comp-newshortcode--mod02"),e.firstElementChild.classList.add("comp-newshortcode--mod03")):"medium"==a?(e.firstElementChild.classList.remove("comp-newshortcode--mod01"),e.firstElementChild.classList.remove("comp-newshortcode--mod03"),e.firstElementChild.classList.add("comp-newshortcode--mod02")):"large"==a&&(e.firstElementChild.classList.remove("comp-newshortcode--mod02"),e.firstElementChild.classList.remove("comp-newshortcode--mod03"),e.firstElementChild.classList.add("comp-newshortcode--mod01"))}catch(e){r=!0,c=e}finally{try{o||null==p.return||p.return()}finally{if(r)throw c}}}};function l(e,t,n,o){var a="",s=e;void 0!==o&&"null"!=typeof o?"?"==e.slice(-1)?s+="max_age="+o:s+="&max_age="+o:o=0,fetch(s).then((function(s){s.json().then((function(s){if(s.length>0)if(s.forEach((function(e){var t=new Date(e.departure_date),o=new Date(e.returning_date),s="";"https://www.passagenspromo.com.br"!=location.origin&&(s="sponsored"),a+='\n                        <a href="'.concat("https://www.passagenspromo.com.br"+e.ecommerce_url+"?"+n,'" target="_blank" class="comp-newshortcode__item" rel="').concat(s,'">\n                            <img class="logo_cia" src="').concat(passagens_promo.plugin_dir+"assets/cia/"+e.lowest_company_code+".png",'" alt="">\n                            <strong class="dep_iata">').concat(e.departure_ap,'</strong>\n                            <small class="dep_city">').concat(e.departure_ap_city,'</small>\n                            <span class="arrow">&#8646;</span>\n                            <strong class="arr_iata">').concat(e.arrival_ap,'</strong>\n                            <small class="arr_city">').concat(e.arrival_ap_city,'</small>\n                            <span class="dep_date">').concat(t.getUTCDate().toLocaleString("pt-BR",{minimumIntegerDigits:2,useGrouping:!1})+" "+r[t.getUTCMonth()],'</span>\n                            <span class="separator">&bull;</span>\n                            <span class="arr_date">').concat(o.getUTCDate().toLocaleString("pt-BR",{minimumIntegerDigits:2,useGrouping:!1})+" "+r[o.getUTCMonth()],'</span>\n                            <span class="price">R$ ').concat(Math.round(e.price_w_fees),"</span>\n                        </a>\n                    ")})),s.length>=1||o>100){var i=(s[0].is_international,"https://www.passagenspromo.com.br/"),c="";"https://www.passagenspromo.com.br"!=location.origin&&(c="sponsored"),a+='\n                        <a class="comp-newshortcode__offers" rel="'.concat(c,'"  href="').concat(i+"?"+n,'" target="_blank">\n                            <span class="offers">Ver mais ofertas</span>\n                        </a>\n                    '),t.parentNode.nextElementSibling.innerHTML=a}else l(e,t,n,o+72);else{c="";"https://www.passagenspromo.com.br"!=location.origin&&(c="sponsored"),a+='\n                    <div class="comp-newshortcode__notfound">\n                        <span>Passagens aéreas até 30% mais baratas</span> <a href="https://www.passagenspromo.com.br/?'.concat(n,'" rel="').concat(c,'" style="cursor:pointer" target="_blank">Encontre sua promo &#8702; </a>\n                    </div>'),t.parentNode.nextElementSibling.innerHTML=a}}))}))}function p(e){for(var t=e+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var r=n[o];" "==r.charAt(0);)r=r.substring(1);if(0==r.indexOf(t))return r.substring(t.length,r.length)}return""}c(),window.addEventListener("resize",c),document.querySelectorAll(".ppromo-origin-filter").forEach((function(e){e.addEventListener("change",(function(){var t=e.parentNode.parentNode.parentNode.getAttribute("data-shortcode"),n=e.parentNode.parentNode.parentNode.getAttribute("data-utm-params");t=t.replace("##","@"+e.value);var o=e.parentNode.parentNode.parentNode;o.clientWidth<430&&o.class,l(t,e,n),function(e,t,n){var o=new Date;o.setTime(o.getTime()+24*n*60*60*1e3);var r="expires="+o.toUTCString();document.cookie=e+"="+t+";"+r+";path=/"}("ppromo_last_origin",e.value)}))}))}]);