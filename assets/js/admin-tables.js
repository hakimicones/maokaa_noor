(function () {
    'use strict';
    if (typeof simpleDatatables === 'undefined') return;

    var baseOptions = {
        searchable: true,
        paging: true,
        perPage: 10,
        perPageSelect: [10, 25, 50, 100],
        labels: {
            placeholder: 'Rechercher...',
            perPage: 'par page',
            noRows: 'Aucun résultat',
            info: 'Affichage {start} à {end} sur {rows} entrées',
            infoEmpty: 'Aucune entrée',
            infoFiltered: '(filtré sur {rows} entrées)'
        }
    };

    document.querySelectorAll('.content-section.active [data-datatable]').forEach(function (table) {
        var opts = Object.assign({}, baseOptions);
        if (table.dataset.dtColumns) {
            try { opts.columns = JSON.parse(table.dataset.dtColumns); } catch (e) {}
        }
        if (table.dataset.dtPerPage) {
            opts.perPage = parseInt(table.dataset.dtPerPage, 10) || 10;
        }
        new simpleDatatables.DataTable(table, opts);
    });
})();
