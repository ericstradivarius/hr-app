$('#editProfileModal').on('hidden.bs.modal', function () {
    $(this).find("input,textarea,select").val('').end();
});