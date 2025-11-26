"use strict";
var KTSigninGeneral = (function () {
    var t, e, i;
    return {
        init: function () {
            // Tampilkan SweetAlert dari flash server (tanpa inline JS)
            var flashEl = document.querySelector("[data-flash]");
            if (flashEl) {
                var type = flashEl.getAttribute("data-flash");
                var msg = flashEl.getAttribute("data-message") || "";
                if (type === "success") {
                    Swal.fire({
                        title: "Berhasil",
                        text: msg || "Anda berhasil masuk.",
                        icon: "success",
                        buttonsStyling: !1,
                        confirmButtonText: "OK, mengerti",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                } else if (type === "error") {
                    Swal.fire({
                        title: "Login Gagal",
                        text: msg || "Mohon periksa kembali kredensial Anda.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "OK, mengerti",
                        customClass: { confirmButton: "btn btn-primary" },
                    });
                }
            }

            (t = document.querySelector("#kt_sign_in_form")),
                (e = document.querySelector("#kt_sign_in_submit")),
                (i = FormValidation.formValidation(t, {
                    fields: {
                        email: {
                            validators: {
                                notEmpty: { message: "Email harus diisi" },
                                emailAddress: {
                                    message: "Format email tidak valid",
                                },
                            },
                        },
                        password: {
                            validators: {
                                notEmpty: { message: "Password harus diisi" },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                        }),
                    },
                })),
                e.addEventListener("click", function (n) {
                    n.preventDefault(),
                        i.validate().then(function (i) {
                            "Valid" == i
                                ? (e.setAttribute("data-kt-indicator", "on"),
                                  (e.disabled = !0),
                                  t.submit())
                                : Swal.fire({
                                      title: "Validasi Gagal",
                                      text: "Mohon periksa kembali input Anda.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "OK, mengerti",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSigninGeneral.init();
});
