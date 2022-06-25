
<link rel="stylesheet" type="text/css" href="<?php echo File::cssFilePath("user.css") ?>">



<h1 class="titleUsr">Utilisateurs</h1>
<div style="width: 30%; margin-left: 35%;margin-top: 2vw;">
    <input id="usr-search" class="form-control mr-sm-2" type="search" placeholder="Search Username" aria-label="Search">
</div>

<div id="formUser">
    <div class="user">
        <p class="iconUtilityTxt adminTxt">Admin</p>
        <p class="logUser">Username</p>
        <p class="logUser">email</p>
        <p class="iconUtilityTxt icopad">Edit</p>
        <p class="iconUtilityTxt icopad">Delete</p>
        <p class="iconUtilityTxt icopad sa">Set Admin</p>
    </div>

<?php
    if (isset($tab_usr)){
        foreach ($tab_usr as $usr) {
            $usr->afficher();
        }
    }
?>

</div>

<script>
    let del_link = "<?php echo File::fileDirection("/user/%_%/delete") ?>";
    let sa_link = "<?php echo File::fileDirection("/user/%_%/setAdmin") ?>";
    let updt_link = "<?php echo File::fileDirection("/user/%_%/update") ?>";
    $(document).ready(() => {
        $(".icoDlt").off("click").on("click", (e) => {
            if (confirm("Etes-vous sur de vouloir supprimer cet utilisateur ?") == true) {
                let id = e.target.parentElement.dataset["uid"];

                location.href = del_link.replaceAll("%_%", id);
            }
        });
        $(".icoSetAdmin").off("click").on("click", (e) => {
            let id = e.target.parentElement.dataset["uid"];

            location.href = sa_link.replaceAll("%_%",id);
        });
        $(".icoUpt").off("click").on("click", (e) => {
            let id = e.target.parentElement.dataset["uid"];

            location.href = updt_link.replaceAll("%_%",id);
        });


        $("#usr-search").off("input").on("input", (e) => {
            let searchTerm = e.target.value.toLowerCase();

            let users = $(".user:not(:first-child)");
            users.each((i) => {
                let val = $(users[i]).children(".logUser").map(function() {
                    return $(this)[0].innerText;
                }).toArray();

                let isIn = val[0].toLowerCase().includes(searchTerm) || val[1].toLowerCase().includes(searchTerm);

                if (isIn) {
                    $(users[i]).show();
                } else {
                    $(users[i]).hide();
                }


            })
        });
    });
</script>
