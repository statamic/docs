/* DARK MODE - SAVE PREFERENCES
=================================================== */
/* Notes...
    - Inspiration - https://www.smashingmagazine.com/2024/03/setting-persisting-color-scheme-preferences-css-javascript/
    - If a color scheme preference was previously stored,
    - select the corresponding option in the color scheme preference UI
    - unless it is already selected.
*/
const colorSchemeStorageItemName = "preferredColorScheme";
const colorSchemeSelectorEl = document.querySelector("#color-scheme");

function restoreColorSchemePreference() {
    const colorScheme = localStorage.getItem(colorSchemeStorageItemName);

    if (!colorScheme) {
        return;
    }

    const option = colorSchemeSelectorEl.querySelector(`[value=${colorScheme}]`);

    if (!option) {
        localStorage.removeItem(colorSchemeStorageItemName);
        return;
    }

    if (option.selected) {
        return;
    }

    option.selected = true;
}

/* Store an event target's value in localStorage under colorSchemeStorageItemName */
function storeColorSchemePreference({ target }) {
    const colorScheme = target.querySelector(":checked").value;
    localStorage.setItem(colorSchemeStorageItemName, colorScheme);
}

if (colorSchemeSelectorEl) {
    restoreColorSchemePreference();

    colorSchemeSelectorEl.addEventListener("input", storeColorSchemePreference);
}