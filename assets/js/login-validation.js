
const app = new Vue({
    el: '#validated-form',
    data: function () {
        return {
            validationErrors: {
            	successMessage: "",
				      errorMessage: "",
              username: null,
              password: null,
              logDetails: {username: '', password: ''},
            }
        }
    },
    methods: {
        submitForm () {
            if (this.validateForm()) {
                alert('Form Submitted')
                //submit form to backend
                var logForm = app.toFormData(app.logDetails);
  				      axios.post('../../controller/loginController.php', logForm)
					.then(function(response){

						if(response.data.error){
							app.errorMessage = response.data.message;
						}
						else{
							app.successMessage = response.data.message;
							app.logDetails = {username: '', password:''};
              //window.location.href="../../view/post/";
							setTimeout(function(){
								window.location.href="../../view/post/";
							},6000);
							
						}
					});
		        return true;
            }
        },
        validateForm (formId = 'validated-form', errorObjectName = 'validationErrors') {
            var nodes = document.querySelectorAll(`#${formId} :invalid`);
            var vm = this; //current vue instance;
        
            Object.keys(this[errorObjectName]).forEach(key => {
                this[errorObjectName][key] = null
            });
        
            if (nodes.length > 0) {
                nodes.forEach(node => {
                    if (node.title) {
                        this[errorObjectName][node.name] = node.title;
                    }
                    else {
                        this[errorObjectName][node.name] = node.validationMessage;
                    }
        
                    node.addEventListener('change', function (e) {
                        vm.validateForm(formId, errorObjectName);
                    });
                });
        
                return false;
            }
            else {
                return true;
            }
        },
        toFormData: function(obj){
			var form_data = new FormData();
			for(var key in obj){
				form_data.append(key, obj[key]);
			}
			return form_data;
		},

		clearMessage: function(){
			app.errorMessage = '';
			app.successMessage = '';
		}
    }
});


/*const app = new Vue({
  el: '#signin',
  data: {
    errors: [],
    username: null,
    password: null,
    logDetails: {username: '', password: ''},
  },
  methods:{
    checkForm: function (e) {
      if (this.username && this.password) {
      	var logForm = app.toFormData(app.logDetails);
		alert(logForm);
		axios.post('../../controller/loginController.php', logForm)
			.then(function(response){

				if(response.data.error){
					app.errorMessage = response.data.message;
				}
				else{
					app.successMessage = response.data.message;
					app.logDetails = {username: '', password:''};
					setTimeout(function(){
						window.location.href="../../view/post/";
					},2000);
					
				}
			});
        return true;
      }
      this.errors = [];

      if (!this.username) {
        this.errors.push('Username required.');
      }
      if (!this.password) {
        this.errors.push('Password required.');
      }
      e.preventDefault();
    },
    toFormData: function(obj){
		var form_data = new FormData();
		for(var key in obj){
			form_data.append(key, obj[key]);
		}
		return form_data;
	},

	clearMessage: function(){
		app.errorMessage = '';
		app.successMessage = '';
	}
  }
});*/