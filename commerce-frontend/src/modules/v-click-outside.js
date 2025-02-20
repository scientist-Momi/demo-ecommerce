// src/directives/v-click-outside.js
export default {
  beforeMount(el, binding) {
    el.clickOutsideEvent = (event) => {
      if (!(el == event.target || el.contains(event.target))) {
          binding.value(event, el);
      }
    };
        document.body.addEventListener("click", el.clickOutsideEvent);
  },
  unmounted(el) {
      document.body.removeEventListener("click", el.clickOutsideEvent);
  },
};
