
import Alpine from 'alpinejs';
import tippy from "tippy.js";

export function Tippy() {
   Alpine.directive('tooltip', (el, {expression}) => {
        tippy([el as Element], {content: expression})
    });
}
