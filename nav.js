const primaryNav = document.querySelector(".primary-navigation");
const navToggle = document.querySelector(".mobile-nav-toggle");
const findMenu = document.querySelector(".find-drop-menu");
const findDrop = document.querySelector(".find-drop-toggle");
const shareMenu = document.querySelector(".share-drop-menu");
const shareDrop = document.querySelector(".share-drop-toggle");

navToggle.addEventListener("click", () => {
    
    const visibility = primaryNav.getAttribute("data-visible");

    if (visibility === "false"){
        primaryNav.setAttribute("data-visible", true);
        navToggle.setAttribute("aria-expanded", true);
    }   else if (visibility === "true"){
        primaryNav.setAttribute("data-visible", false);
        navToggle.setAttribute("aria-expanded", false);
    }
});


findDrop.addEventListener("click", () => {

    const visibility = findMenu.getAttribute("data-visible")

    if (visibility === "false"){
        findMenu.setAttribute("data-visible", true);
        findDrop.setAttribute("aria-expanded", true);
        shareMenu.setAttribute("data-visible", false);
        shareDrop.setAttribute("aria-expanded", false);
    }   else if (visibility === "true"){
        findMenu.setAttribute("data-visible", false);
        findDrop.setAttribute("aria-expanded", false);
    }
}

) 
shareDrop.addEventListener("click", () => {

    const visibility = shareMenu.getAttribute("data-visible")

    if (visibility === "false"){
        shareMenu.setAttribute("data-visible", true);
        shareDrop.setAttribute("aria-expanded", true);
        findMenu.setAttribute("data-visible", false);
        findDrop.setAttribute("aria-expanded", false);
    }   else if (visibility === "true"){
        shareMenu.setAttribute("data-visible", false);
        shareDrop.setAttribute("aria-expanded", false);
    } 
}

) 

