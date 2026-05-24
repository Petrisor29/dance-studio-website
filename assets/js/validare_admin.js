// assets/js/validare_admin.js

document.addEventListener("DOMContentLoaded", function() {
    const form = document.querySelector("form");
    if (!form) return;

    form.addEventListener("submit", function(event) {
        let erori = [];

        // 1. Determinam tipul formularului dupa campurile ascunse (hidden inputs)
        if (form.querySelector("input[name='adauga_eveniment'], input[name='editeaza_eveniment']")) {
            erori = valideazaEvenimente(form);
        } 
        else if (form.querySelector("input[name='adauga_curs'], input[name='editeaza_curs']")) {
            erori = valideazaCursuri(form);
        } 
        else if (form.querySelector("input[name='adauga_instructor'], input[name='editeaza_instructor']")) {
            erori = valideazaInstructori(form);
        }

        // 2. Daca am colectat erori, blocam trimiterea si le afisam
        afiseazaErori(form, erori, event);
    });
});

// --- FUNCTII MODULARE DE VALIDARE ---

function valideazaEvenimente(form) {
    let erori = [];
    let nume = form.querySelector("input[name='nume']").value.trim();
    let data_ev = form.querySelector("input[name='data_eveniment']").value.trim();
    let locatie = form.querySelector("input[name='locatie']").value.trim();

    if (nume.length < 3) {
        erori.push("- Numele evenimentului trebuie sa aiba minim 3 caractere.");
    }
    if (locatie.length < 3) {
        erori.push("- Locatia trebuie sa aiba minim 3 caractere.");
    }
    
    let regexData = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
    if (!regexData.test(data_ev)) {
        erori.push("- Selectati o data calendaristica valida.");
    }

    return erori;
}

function valideazaCursuri(form) {
    let erori = [];
    let nume = form.querySelector("input[name='nume']").value.trim();
    let descriere = form.querySelector("textarea[name='descriere']").value.trim();
    let durata = form.querySelector("input[name='durata']").value.trim();

    if (nume.length < 3) {
        erori.push("- Numele cursului trebuie sa aiba minim 3 caractere.");
    }
    if (descriere.length < 5) {
        erori.push("- Descrierea este prea scurta.");
    }
    if (isNaN(durata) || parseInt(durata) <= 0) {
        erori.push("- Durata trebuie sa fie un numar pozitiv in minute.");
    }

    return erori;
}

function valideazaInstructori(form) {
    let erori = [];
    let nume = form.querySelector("input[name='nume']").value.trim();
    let specializare = form.querySelector("input[name='specializare']").value.trim();

    if (nume.length < 3) {
        erori.push("- Numele instructorului trebuie sa aiba minim 3 caractere.");
    }
    if (specializare.length < 3) {
        erori.push("- Specializarea trebuie sa contina minim 3 caractere.");
    }

    return erori;
}

// --- FUNCTIE PENTRU AFISARE INTERFATA ---

function afiseazaErori(form, erori, event) {
    // Curatam mesajele de eroare anterioare
    const vechiulContainer = document.getElementById("js-errors");
    if (vechiulContainer) {
        vechiulContainer.remove();
    }

    // Daca totul este corect, lasam formularul sa plece spre server
    if (erori.length === 0) {
        return; 
    }

    // Oprim reincarcarea paginii
    event.preventDefault();

    // Construim caseta vizuala cu erori
    const divErori = document.createElement("div");
    divErori.id = "js-errors";
    divErori.style.cssText = "color: #c0392b; background-color: #fadbd8; padding: 12px; border-radius: 4px; margin-bottom: 15px; border-left: 4px solid #c0392b;";
    divErori.innerHTML = "<strong>Va rugam sa corectati urmatoarele erori:</strong><br><br>" + erori.join("<br>");
    
    // Inseram caseta la inceputul formularului
    form.insertBefore(divErori, form.firstChild);
}