class Organizer {

    init() {
        this.setEvents();
    }

    setEvents() {

        jQuery('.content-panel').on('click', '.ml-element', (event) => {
            var self = event.currentTarget;

            var id = jQuery(self).attr('id');
            var date = jQuery(self).data('date');

            var data = {
                month: id,
                date: date
            };

            this.ajaxController(data, Urls.editUrl);
        });



        jQuery('.content-panel').on('click', '.back-btn', (event) => {

            this.ajaxController({}, Urls.indexUrl);
        });



        jQuery('.content-panel').on('click', '.save-month-btn', (event) => {

            var msg = this.checkFields();

            if (msg != "") {
                window.alert(msg);
            } else {
                var id = jQuery('#id').val();

                var data = {
                    month: id,
                    month_id: id,
                    cost: jQuery("#cost-value").val(),
                    cost_id: jQuery('#cost_id').val(),
                    description: jQuery('#cost-description').val(),
                    date: jQuery("#date").val(),
                    budget: jQuery("#budget").val()
                };

                this.ajaxController(data, Urls.updateUrl);
            }

        });

        jQuery('.content-panel').on('click', '.remove-btn', (event) => {

            var self = event.currentTarget;

            var data = {
                month: jQuery('#id').val(),
                month_id: jQuery('#id').val(),
                cost_id: jQuery(self).data('cost-id'),
                date: jQuery("#date").val()
            };

            this.ajaxController(data, Urls.removeUrl);
        });

        jQuery('.content-panel').on('click', '.edit-btn', (event) => {

            var self = event.currentTarget;

            var data = {
                month: jQuery('#id').val(),
                month_id: jQuery('#id').val(),
                cost_id: jQuery(self).data('cost-id'),
                date: jQuery("#date").val()


            };

            this.ajaxController(data, Urls.editCostUrl);
        });

        jQuery('.home').on('click', (event) => {

            this.ajaxController({}, Urls.indexUrl);

        });

    }

    checkFields() {

        var budget = jQuery("#budget");
        var costDescription = jQuery('#cost-description');
        var costValue = jQuery("#cost-value");

        var msg = '';
        if (budget.val() == "") {
            msg += 'wypełnij pole dostępnego budżetu!\n';
        }
        if (!budget.val().match(/^\d+$/)) {
            msg += 'budżet podaj jako liczbę całkowitą!\n';
        }
        if (costDescription.val() !== "" && costValue.val() == "") {
            msg += 'wprowadź wartość kosztu!\n';
        }
        if (costValue.val() !== "" && costDescription.val() == "") {
            msg += 'wprowadź opis kosztu!\n';
        }
        if (!costValue.val().match(/^\d+$/) && costValue.val() != "") {
            msg += 'wartość kosztu musi być liczbą całkowitą!\n';
        }
        return msg;
    }

    ajaxController(data = null, url) {

        this.ajaxHandler(data, url);
    }

    ajaxHandler(postData, url) {


        var link = (postData.month ? url + postData.month : url);

        console.log(" LINK: ", link);

        jQuery.ajax({
            type: 'POST',
            url: link,
            data: postData,
            success: (response) => {

//                console.log(response);
                this.upgradeContentPanel(response);

            },
            error: (request, status, error) => {
                console.log("request: ", request);
                console.log("status: ", status);
                console.log("error: ", error);
                window.alert("error when cart requesting");

            }

        });

    }

    upgradeContentPanel(response) {
        jQuery(".content-panel").html(response);
    }
}

var organizer = new Organizer();
organizer.init();


