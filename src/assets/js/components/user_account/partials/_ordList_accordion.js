export const _odList_accordion = () => {
  /**
   * Expand/hide accordion for orders display
   * =======================================================================================
   */
  document.querySelectorAll(".accordion__button").forEach((button) => {
    button.addEventListener("click", () => {
      // const accordionContent = button.nextElementSibling;
      button.classList.toggle("accordion__button--active");
      // if (button.classList.contains("accordion__button--active")) {
      //   accordionContent.style.maxHeight =
      //     accordionContent.scrollHeight + "px";
      //   // accordionContent.style.paddingTop = "1rem";
      //   // accordionContent.style.paddingBottom = "1rem";
      // } else {
      //   accordionContent.style.maxHeight = 0;
      // }
    });
  });
};
