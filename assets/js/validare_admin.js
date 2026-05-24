// assets/js/validare_admin.js
document.addEventListener("DOMContentLoaded", function() {
    // Cautam daca exista un formular pe pagina curenta
    const form = document.querySelector("form");
    
    // Daca suntem pe o pagina cu tabel (fara formular), scriptul se opreste aici
    if (!form) return;
    
    form.addEventListener("submit", function(event) {
        let erori = [];
        
        // --- 1. Validare comuna pentru toate modulele ---
        const nume = form.querySelector("input[name='nume']");
        if (nume && nume.value.trim().length < 3) {
            erori.push("- Numele trebuie sa aiba minim 3 caractere.");
        }
        
        // --- 2. Validari specifice: Modul Evenimente ---
        const data_ev = form.querySelector("input[name='data_eveniment']");
        if (data_ev) {
            const regexData = /^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/;
            if (!regexData.test(data_ev.value.trim())) {
                erori.push("- Selectati o data calendaristica valida din picker.");
            }
        }
        
        const locatie = form.querySelector("input[name='locatie']");
        if (locatie && locatie.value.trim().length < 3) {
            erori.push("- Locatia trebuie sa aiba minim 3 caractere.");
        }
        
        // --- 3. Validari specifice: Modul Cursuri ---
        const descriere = form.querySelector("textarea[name='descriere']");
        if (descriere && descriere.value.trim().length < 5) {
            erori.push("- Descrierea este prea scurta.");
        }
        
        const durata = form.querySelector("input[name='durata']");
        if (durata) {
            const valDurata = parseInt(durata.value.trim());
            if (isNaN(valDurata) || valDurata <= 0) {
                erori.push("- Durata trebuie sa fie un numar pozitiv in minute.");
            }
        }
        
        // --- 4. Validari specifice: Modul Instructori ---
        const specializare = form.querySelector("input[name='specializare']");
        if (specializare && specializare.value.trim().length < 3) {
            erori.push("- Specializarea trebuie sa contina minim 3 caractere.");
        }
        
        // --- Afisarea Erorilor ---
        const vechiulContainer = document.getElementById("js-errors");
        if (vechiulContainer) {
            vechiulContainer.remove();
        }
        
        if (erori.length > 0) {
            event.preventDefault(); // Blocam trimiterea
            
            const divErori = document.createElement("div");
            divErori.id = "js-errors";
            divErori.style.cssText = "color: #c0392b; background-color: #fadbd8; padding: 12px; border-radius: 4px; margin-bottom: 15px; border-left: 4px solid #c0392b;";
            divErori.innerHTML = "<strong>Va rugam sa corectati urmatoarele erori:</strong><br><br>" + erori.join("<br>");
            
            form.insertBefore(divErori, form.firstChild);
        }
    });
});