let style = localStorage.getItem("style");

if (style == null) {
    setTheme("light");
} else {
    setTheme(style);
}

function setTheme(theme) {
    if (theme == "light") {
        document.documentElement.setAttribute('data-bs-theme', 'light')
    } else if (theme == "dark") {
        document.documentElement.setAttribute("data-bs-theme", "dark");
    }
    localStorage.setItem("style", theme);
}
