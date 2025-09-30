const deleteAction = ({
    text,
    url,
}) => {
    Swal.fire({
        title: "Hapus Data",
        text: text,
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#d75350",
        cancelButtonColor: "#74788d",
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then(function (e) {
        if(e.value) {
            var form = document.getElementById('action-form');
            form.action = url;
            form.submit();
        }
    })
};