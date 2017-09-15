(function(window, $) {

    "use strict";

    window.Template = {

        form: function() {

            "use strict";

            $(function() {
                $('form[data-ajax-form]').ssdForm({

                    extendBehaviours: {

                        redirectOrFadeOut: function(form, data) {

                            if (data.redirect) {
                                return this.redirect(form, data);
                            }

                            return this.fadeOutShowMessage(form, data);
                        }

                    }

                });
            });

        },

        resendActivationEmail: function() {

            "use strict";

            $(document).on('click', '#resendActivation', function(event) {

                event.preventDefault();
                event.stopPropagation();

                var trigger = $(this),
                    wrapper = trigger.closest('[data-form-wrapper]'),
                    form = wrapper.find('form'),
                    message = wrapper.find('[data-confirmation]'),
                    url = trigger.prop('href'),
                    email = $('#email').val();

                $.ajax({
                    dataType: 'json',
                    url: url + '?email=' + email,
                    success: function(data) {

                        form.fadeOut(200, function() {

                            message.html(data.message).fadeIn();

                        });

                    },
                    error: function(jqXHR) {

                        $('[data-validation="email"] [data-case]').removeClass('show');
                        $('[data-validation="email"] [data-case="' + jqXHR.responseJSON.email[0] + '"]').addClass('show');

                    }
                });

            });

        },

        init: function() {

            "use strict";

            this.form();
            this.resendActivationEmail();

        }

    };

    window.Template.init();


})(window, window.jQuery);