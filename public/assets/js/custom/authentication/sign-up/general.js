"use strict";
var KTSignupGeneral = (function () {
    var e,
        t,
        a,
        s,
        r = function () {
            return 100 === s.getScore();
        };
    return {
        init: function () {
            (e = document.querySelector("#kt_sign_up_form")),
                (t = document.querySelector("#kt_sign_up_submit")),
                (s = KTPasswordMeter.getInstance(
                    e.querySelector('[data-kt-password-meter="true"]')
                )),
                (a = FormValidation.formValidation(e, {
                    fields: {
                        nama: {
                            validators: {
                                notEmpty: {
                                    message: "Nama Lengkap is required",
                                },
                            },
                        },
                        email: {
                            validators: {
                                notEmpty: {
                                    message: "Email is required",
                                },
                                emailAddress: {
                                    message: "The value is not a valid email",
                                },
                            },
                        },
                        password: {
                            validators: {
                                notEmpty: {
                                    message: "Password is required",
                                },
                                stringLength: {
                                    min: 8,
                                    message:
                                        "Password must be at least 8 characters long",
                                },
                            },
                        },
                        password_confirmation: {
                            validators: {
                                notEmpty: {
                                    message:
                                        "Password confirmation is required",
                                },
                                identical: {
                                    compare: function () {
                                        return e.querySelector(
                                            '[name="password"]'
                                        ).value;
                                    },
                                    message:
                                        "Password and its confirm are not the same",
                                },
                            },
                        },
                        terms: {
                            validators: {
                                notEmpty: {
                                    message: "You must accept the terms",
                                },
                            },
                        },
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger({
                            event: { password: !1 },
                        }),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: ".fv-row",
                            eleInvalidClass: "",
                            eleValidClass: "",
                        }),
                    },
                })),
                t.addEventListener("click", function (r) {
                    r.preventDefault(),
                        a.revalidateField("password"),
                        a.validate().then(function (a) {
                            "Valid" == a
                                ? (t.setAttribute("data-kt-indicator", "on"),
                                  (t.disabled = !0),
                                  setTimeout(function () {
                                      t.removeAttribute("data-kt-indicator"),
                                          (t.disabled = !1),
                                          Swal.fire({
                                              text: "Kamu berhasil mendaftar!",
                                              icon: "success",
                                              buttonsStyling: !1,
                                              confirmButtonText: "OK!",
                                              customClass: {
                                                  confirmButton:
                                                      "btn btn-primary",
                                              },
                                          }).then(function (t) {
                                              t.isConfirmed && e.submit();
                                          });
                                  }, 1500))
                                : Swal.fire({
                                      text: "Maaf, terjadi kesalahan, silakan coba lagi.",
                                      icon: "error",
                                      buttonsStyling: !1,
                                      confirmButtonText: "OK!",
                                      customClass: {
                                          confirmButton: "btn btn-primary",
                                      },
                                  });
                        });
                }),
                e
                    .querySelector('input[name="password"]')
                    .addEventListener("input", function () {
                        this.value.length > 0 &&
                            a.updateFieldStatus("password", "NotValidated");
                    });
        },
    };
})();
KTUtil.onDOMContentLoaded(function () {
    KTSignupGeneral.init();
});
