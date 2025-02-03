document.getElementById('toggleBg').addEventListener('change', function () {
    if (this.checked) {
        document.body.classList.remove('body_effects');
    } else {
        document.body.classList.add('body_effects');
    }
});
let pseudo = document.cookie.replace(/(?:(?:^|.*;\s*)pseudo\s*\=\s*([^;]*).*$)|^.*$/, "$1") || null;
console.log("Pseudo :", pseudo);
if (pseudo==="null") {
    console.log("Pas de pseudo enregistré");
    pseudo = prompt("Quel est votre pseudo ?");
    document.cookie = `pseudo=${pseudo}`;
}
function saveScore(score, jeu, unit) {
    if (document.currentScript && document.currentScript.src) {
        fetch('savescore.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `pseudo=${encodeURIComponent(pseudo)}&score=${score}&unit=${encodeURIComponent(unit)}&jeu=${encodeURIComponent(jeu)}`
        })
            .then(response => response.text())
            .then(data => {
                console.log("Score enregistré :", data);
            })
            .catch(error => console.error("Erreur :", error));
    } else {
        console.error("L'appel doit venir d'un fichier JavaScript externe.");
    }
}
