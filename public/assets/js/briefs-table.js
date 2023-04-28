// Trie les lignes du tableau en fonction de la valeur de la colonne spécifiée par son index
const compare = function (index, asc) {
  return function (row1, row2) {
    const getValue = function (row, index) {
      const cell = row.children[index];
      return cell ? cell.textContent.trim() : "";
    };

    const sortResult = function (value1, value2) {
      const date1 = moment(value1, "DD/MM/YYYY");
      const date2 = moment(value2, "DD/MM/YYYY");
      if (date1.isValid() && date2.isValid()) {
        return date1.diff(date2);
      } else if (!isNaN(value1) && !isNaN(value2)) {
        return parseFloat(value1) - parseFloat(value2);
      } else {
        return value1.localeCompare(value2);
      }
    };

    const rowValue1 = getValue(asc ? row1 : row2, index);
    const rowValue2 = getValue(asc ? row2 : row1, index);
    return sortResult(rowValue1, rowValue2);
  };
};

const briefsTable = document.querySelector("#briefsTable");
const thx = briefsTable.querySelectorAll("th");
const trxb = briefsTable.querySelectorAll("tbody tr");

// Au clic, trie en fonction de la colonne cliquée
thx.forEach(function (th) {
  th.addEventListener("click", function () {
    let sortedRows = Array.from(trxb).sort(
      compare(parseInt(th.dataset.sort), (this.asc = !this.asc))
    );
    // Ajoute chaque ligne triée à la fin du tbody
    sortedRows.forEach(function (sortedRow) {
      briefsTable.querySelector("tbody").appendChild(sortedRow);
    });
  });
});
