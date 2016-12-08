<script>
    $(function() {
        $.contextMenu({
            selector: '.left-clicked',
            trigger: 'left',
            callback: function (key, options) {
                var id = this.attr('id');
                var m = 'clicked: ' + key;
                if (key == 'redmine') {
                    window.open('http://soporte.bloonde.com/issues/' + id,'_blank');
                }
                if (key == 'edit') {
                    $('#click-'+id).click();
                }
            },
            items: {
                "redmine": {name: "Ir a Redmine"},
                "sep1": "---------",
                "edit": {name: "Editar"}
            }
        })
    });
</script>