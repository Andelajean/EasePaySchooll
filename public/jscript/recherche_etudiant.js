
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search-input");

    searchInput.addEventListener("input", function () {
        let query = this.value;

        if (query.length > 1) {
            fetch(`/search-eleves?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    let suggestions = "";
                    data.forEach(eleve => {
                        suggestions += `<li class="p-2 hover:bg-blue-400 cursor-pointer" data-id="${eleve.id}">${eleve.nom_complet}</li>`;
                    });

                    showSuggestions(suggestions);
                })
                .catch(error => console.error("Erreur lors de la recherche :", error));
        } else {
            showSuggestions("");
        }
    });

    function showSuggestions(content) {
        let resultBox = document.getElementById("search-results");
        if (!resultBox) {
            resultBox = document.createElement("ul");
            resultBox.id = "search-results";
            resultBox.className = "absolute bg-white shadow-lg rounded-lg mt-2 w-full text-black";
            searchInput.parentNode.appendChild(resultBox);
        }
        resultBox.innerHTML = content;

        // Ajouter un événement pour rediriger l'utilisateur lorsqu'il clique sur un élève
        resultBox.querySelectorAll("li").forEach(item => {
            item.addEventListener("click", function () {
                let eleveId = this.getAttribute("data-id");
                window.location.href = `/detail-eleve/${eleveId}`;
            });
        });
    }
});
 //imprimer

 function printTable() {
    var tableContent = document.getElementById("payment-table").outerHTML;
    var newWindow = window.open("", "_blank");
    newWindow.document.write("<html><head><title>Impression</title>");
    newWindow.document.write("<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 8px; text-align: left; }</style>");
    newWindow.document.write("</head><body>");
    newWindow.document.write(tableContent);
    newWindow.document.write("</body></html>");
    newWindow.document.close();
    newWindow.print();
}
