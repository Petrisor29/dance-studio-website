// assets/js/admin.js

function valideazaFormular(formular) {
    var nume = formular.nume.value.trim();
    var specializare = formular.specializare.value.trim();
    var descriere = formular.descriere.value.trim();
    
    if (nume.length < 3) {
        alert("Numele trebuie sa aiba cel putin 3 caractere!");
        return false;
    }
    if (specializare.length < 3) {
        alert("Specializarea trebuie sa aiba cel putin 3 caractere!");
        return false;
    }
    if (descriere.length < 10) {
        alert("Descrierea trebuie sa fie mai detaliata (minim 10 caractere)!");
        return false;
    }
    return true;
}

function confirmaStergerea() {
    return confirm("Sigur doriti sa stergeti? Actiunea este ireversibila!");
}