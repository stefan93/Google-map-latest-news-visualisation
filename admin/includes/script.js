$(document).ready(function(){
    jQuery(document).on("click","[triger=dodaj_vest]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        var grad=$('select[name=grad-'+id+']').val();
        var kat=$('select[name=kategorija-'+id+']').val();
        jQuery.ajax({
            url: "ajax.dodaj_vest.php?q="+id+"&kat="+kat+"&grad="+grad,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=obrisi_vest]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        jQuery.ajax({
            url: "ajax.korpa.php?q="+id+"&kontrola=ukorpu",
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=isprazni_korpu]",function(event){
        event.preventDefault();
        jQuery.ajax({
            url: "ajax.korpa.php?kontrola=ispraznikorpu",
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=ucitaj_nove_vesti]",function(event){
        event.preventDefault();
        var n=$(this).attr("id");
        jQuery.ajax({
            url: "ajax.ucitaj_nove_vesti.php?n="+n,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=promeni_grad]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        window.open("promeni_grad.php?q="+id,"_blank","width=1000, height=500, top=100, left=100");
    });
    jQuery(document).on("click","[triger=odobri_vest]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        var kat=$('select[name=kategorija-'+id+']').val();
        var id_grada=$("select[name=grad-"+id+"]").val();
        jQuery.ajax({
            url: "ajax.odobri_vest.php?q="+id+"&grad="+id_grada+"&kat="+kat,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=promeni_kategoriju]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        var kat=$('select[name=kategorija-'+id+']').val();
        $("#"+id+".promena-kategorije").load("ajax.promeni_kategoriju.php?q="+id+"&kat="+kat);
        jQuery.ajax({
            url: "ajax.promeni_kategoriju.php?q="+id+"&kat="+kat,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=dodaj_novinu]",function(event){
        event.preventDefault();
        var naziv=$("[name=naziv_nove_novine]").val();
        var link=$("[name=link_nove_novine]").val();
        var tip="dodaj_novu_novinu";
        jQuery.ajax({
            url: "ajax.podesavanja.php?tip="+tip+"&naziv="+naziv+"&link="+link,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=dodaj_novinu]",function(event){
        event.preventDefault();
        var naziv=$("[name=naziv_nove_novine]").val();
        var link=$("[name=link_nove_novine]").val();
        var tip="dodaj_novu_novinu";
        jQuery.ajax({
            url: "ajax.podesavanja.php?tip="+tip+"&naziv="+naziv+"&link="+link,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=sacuvaj_novine_za_auto]",function(event){
        event.preventDefault();
        var novine=[];
        $(".novine-za-auto").each(function() {
            var s;
            if ($(this).is(":checked"))
                s=1;
            else
                s=0;
            novine.push(
                {
                    "id_novina": $(this).attr("value"),
                    "set": s
                });
        });
        novine=JSON.stringify(novine);
        var tip="sacuvaj_rss_za_auto";
        jQuery.ajax({
            url: "ajax.podesavanja.php?tip="+tip+"&novine="+novine,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=dodaj_rss_link]",function(event){
        event.preventDefault();
        var link=$("[name=novi_rss_link]").val();
        var novina=$("select[name=novina_za_rss_link]").val();
        var tip="dodaj_rss_link";
        $(this).load("ajax.podesavanja.php?tip="+tip+"&novina="+novina+"&link="+link);
        jQuery.ajax({
            url: "ajax.podesavanja.php?tip="+tip+"&novina="+novina+"&link="+link,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=izbrisi_rss_link]",function(event){
        event.preventDefault();
        var id=$(this).attr("id");
        var tip="izbrisi_rss_link";
        jQuery.ajax({
            url: "ajax.podesavanja.php?tip="+tip+"&id="+id,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=promeni_aktivni_grad]",function(event){
        event.preventDefault();
        var id_vesti=$(this).attr("id");
        var id_grada=$("select[name=grad-"+id_vesti+"]").val();
        jQuery.ajax({
            url: "ajax.promeni_akt_grad.php?&id_grada="+id_grada+"&id_vesti="+id_vesti,
            success: function(data) {
                if (confirm(data)) {
                    location.reload();
                }
            }
        });
    });
    jQuery(document).on("click","[triger=odobri-cekirano]",function(event){
        event.preventDefault();
        var brk=false;
        var num=0;
        var cb=$("input[name=cb]:checked");
        var trazeno=cb.length;
            $("input[name=cb]:checked").each( function(index) {
            var id=$(this).attr("id");
            var kat=$('select[name=kategorija-'+id+']').val();
            var id_grada=$("select[name=grad-"+id+"]").val();
            jQuery.ajax({
                url: "ajax.odobri_vest.php?q="+id+"&grad="+id_grada+"&kat="+kat,
                success: function() {
                    num++;
                },
                failed: function(data,status) {
                    alert("Greska: "+data+" .Status"+status);
                    brk=true;
                }
            });
            if (brk)
                return false;
        });
        if (trazeno==num)
            alert("Odobreno"+num+" vesti");
        else
            alert("Greska: trazeno="+trazeno+", odobreno+"+num);
    });


});