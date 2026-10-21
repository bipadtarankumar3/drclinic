

const accordionBtns = document.querySelectorAll(".accordion");

accordionBtns.forEach((accordion) => {
  accordion.onclick = function () {
    const currentAccordion = this;

    accordionBtns.forEach((acc) => {
      if (acc !== currentAccordion) {
        acc.classList.remove("is-open");
        acc.nextElementSibling.style.maxHeight = null;
      }
    });

    currentAccordion.classList.toggle("is-open");

    let content = this.nextElementSibling;

    if (content.style.maxHeight) {
      content.style.maxHeight = null;
    } else {
      content.style.maxHeight = content.scrollHeight + "px";
    }
  };
});


// end acordiam










