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

function updateDarkClass(colorScheme) {
    const htmlEl = document.documentElement;
    
    if (colorScheme === "dark") {
        htmlEl.classList.add("dark");
    } else if (colorScheme === "light") {
        htmlEl.classList.remove("dark");
    } else if (colorScheme === "system") {
        // Check system preference
        if (window.matchMedia && window.matchMedia("(prefers-color-scheme: dark)").matches) {
            htmlEl.classList.add("dark");
        } else {
            htmlEl.classList.remove("dark");
        }
    }
}

function restoreColorSchemePreference() {
    const colorScheme = localStorage.getItem(colorSchemeStorageItemName);

    if (!colorScheme) {
        // Default to system preference if no stored preference
        updateDarkClass("system");
        return;
    }

    const option = colorSchemeSelectorEl.querySelector(`[value=${colorScheme}]`);

    if (!option) {
        localStorage.removeItem(colorSchemeStorageItemName);
        updateDarkClass("system");
        return;
    }

    if (option.selected) {
        updateDarkClass(colorScheme);
        return;
    }

    option.selected = true;
    updateDarkClass(colorScheme);
}

/* Store an event target's value in localStorage under colorSchemeStorageItemName */
function storeColorSchemePreference({ target }) {
    const colorScheme = target.querySelector(":checked").value;
    localStorage.setItem(colorSchemeStorageItemName, colorScheme);
    updateDarkClass(colorScheme);
}

if (colorSchemeSelectorEl) {
    restoreColorSchemePreference();

    colorSchemeSelectorEl.addEventListener("input", storeColorSchemePreference);
    
    // Listen for system preference changes when "system" is selected
    if (window.matchMedia) {
        const darkModeMediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
        darkModeMediaQuery.addEventListener("change", (e) => {
            const selectedValue = colorSchemeSelectorEl.querySelector(":checked")?.value;
            if (selectedValue === "system") {
                updateDarkClass("system");
            }
        });
    }
}