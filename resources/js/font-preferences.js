/* FONT PREFERENCES
=================================================== */
/* Notes...
    - Inspiration - https://www.smashingmagazine.com/2024/03/setting-persisting-color-scheme-preferences-css-javascript/
    - If a font preference was previously stored,
    - select the corresponding option in the font preference UI
    - unless it is already selected.
*/
const fontStorageItemName = "preferredFont";
const fontSelectorEl = document.querySelector(".o-font-toggle");

function restoreFontPreference() {
    const font = localStorage.getItem(fontStorageItemName);

    if (!font) {
        return;
    }

    const option = fontSelectorEl.querySelector(`[value="${font}"]`);

    if (!option) {
        localStorage.removeItem(fontStorageItemName);
        return;
    }

    if (option.checked) {
        return;
    }

    option.checked = true;
}

/* Store an event target's value in localStorage under fontStorageItemName */
function storeFontPreference({ target }) {
    const font = target.value;
    localStorage.setItem(fontStorageItemName, font);
}

if (fontSelectorEl) {
    restoreFontPreference();

    // Listen for changes on the radio buttons
    const radioButtons = fontSelectorEl.querySelectorAll('input[type="radio"]');
    radioButtons.forEach(radio => {
        radio.addEventListener("change", storeFontPreference);
    });
}