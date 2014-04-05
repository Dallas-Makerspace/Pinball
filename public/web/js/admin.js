/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* Table initialisation */
$(document).ready(function() {
	
        
        
           $('#datetimepicker1').datetimepicker();
           

        /** Table datatables **/
        $('#user_table').dataTable( {
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
                    },
		  "aoColumns": [ 
                        null,
                        null,
                      { "bSearchable": false, "bSortable": false },
                      { "bSearchable": false, "bSortable": false },
                      { "bSearchable": false, "bSortable": false }

                    ] 
            });
        
        $('#pinball_table').dataTable( {
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
               "aoColumns": [ 
                        null,
                        null,
                      { "bSearchable": false, "bSortable": false },
                      { "bSearchable": false, "bSortable": false },
                      { "bSearchable": false, "bSortable": false }

                    ] 
            });
        
        $('#highscore_table').dataTable( {
        "sDom": "<'row'<'col-xs-6'T><'col-xs-6'f>r>t<'row'<'col-xs-6'i><'col-xs-6'p>>",
        "sPaginationType": "bootstrap",
		"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
		},
               "aoColumns": [ 
                        null,
                        null,
                        null,
                        null,
                      { "bSearchable": false, "bSortable": false },

                    ] 
            });
            
        /** Form Ajax Calls **/
        $("#form_register_user").ajaxForm({
                    before : function()
                    {
                        $("#errorMessage_adduser").hide(); 
                        $("#successMessage_addUser").hide();
                    },
                    clearForm: true,
                    datatype : 'json',
                    success : function(data)
                    {
                        
                        if(typeof data.errorMessages === "undefined")
                        {
                            displayErrorMessages("adduser_email", "");       
                            displayErrorMessages("adduser_username", "");
                        }
                        else
                        {
                            data.errorMessages.email = 
                                    (typeof data.errorMessages.email === 'undefined') ? "" : data.errorMessages.email;
                           
                            data.errorMessages.username = 
                                    (typeof data.errorMessages.username === 'undefined') ? "" : data.errorMessages.username;

                            
                            displayErrorMessages("adduser_email", data.errorMessages.email);       
                            displayErrorMessages("adduser_username", data.errorMessages.username);
                        }

                          if(data.error === '1')
                          {
                              $("#errorMessage_adduser").show(); 
                              $("#successMessage_addUser").hide();
                          }
                          else
                          {
                              var datauserid = "data-userid="  + "'" + data.user.id + "'   ";
                                $("#successMessage_addUser").show();
                                $("#errorMessage_adduser").hide();
                                $('#user_table').dataTable().fnAddData([
                                    data.user.username,
                                    data.user.email,
                                    "<td class='btncontainer'><button " + datauserid + " class='btn btn-success btn-sm user_resetpassword'>Reset Password</button></td>",
                                    "<td class='btncontainer'><button " + datauserid  + " class='btn btn-danger btn-sm user_disable'>Disable User</button></td>",
                                    "<td class='btncontainer'><button " + datauserid  + " class='btn btn-success btn-sm user_admin'>Make Admin</button></td>"
                                ]); 
                                $("#select_user_highscore").append("<option value='"+ data.user.id +"'>" + data.user.username + "</option>");
            
                                
                          }
                    },
                    error: function()
                    {
                             $("#errorMessage_adduser").show(); 
                             $("#successMessage_addUser").hide();
                    }
                    
                });
        
        $("#addMachine").ajaxForm({
            before : function()
            {
                $("#addpinball_message").hide(); 
            },
            datatype : 'json',
            clearForm: true,
            success : function(data)
            {
               
                if(data.success === false)
                {
                   
                        displayErrorMessages("machine_name", "");       
                        displayErrorMessages("machine_description", "");
                        displayErrorMessages("machine_pics", "");
                        
                        if(typeof data.errors === 'undefined')
                        {
                            data.errors = {};
                            data.errors.name = "";
                            data.errors.description = "";
                            data.errors.picture = "";
                        }
                        data.errors.name = 
                                    (typeof data.errors.name === 'undefined') ? "" : data.errors.name;
                       
                        data.errors.description = 
                                    (typeof data.errors.description === 'undefined') ? "" : data.errors.description;

                        data.errors.picture = 
                                    (typeof data.errors.picture === 'undefined') ? "" : data.errors.picture;

                        displayErrorMessages("machine_name", data.errors.name);       
                        displayErrorMessages("machine_description", data.errors.description);
                        displayErrorMessages("machine_pics", data.errors.picture);
                        
                        $("#addpinball_message").removeClass("alert-success");
                        $("#addpinball_message").addClass("alert-danger");
                        $("#addpinball_message span").html("There was an error in adding the pinball machine.");
                        $("#addpinball_message").show();

                }
                else
                {
                    var url = pinballMachineUrl.replace(/MACHINE_ID_REPLACE/g, data.machine.id);
                    $("#addpinball_message").removeClass("alert-danger");
                    $("#addpinball_message").addClass("alert-success");
                    $("#addpinball_message span").html("You have successfully added a pinball machine");
                    $("#addpinball_message").show();
                    $("#pinball_table").dataTable().fnAddData([
                        data.machine.name ,
                        data.machine.description,
                        "<button data-id='" + data.machine.id + "'   class='btn btn-info edit_machine_modal'>Edit </button>",
                        "<a class='btn btn-success' href='" +  url  +"'>View</a>",
                        "<button data-id='" +data.machine.id + "' class='btn btn-danger pinball_retire'>Retire</button>"
                        ]);
                        
                        $("#pinball_table tr").each(function(){
                            $(this).find('td').each(function(index){
                               if(index > 1)
                               {
                                   if($(this).hasClass("btncontainer") === false)
                                   {
                                       $(this).addClass('btncontainer');
                                   }
                               } 
                        });
                    });
                   
                }
            },
            errors: function()
            {
                   $("#addpinball_message").removeClass("alert-success");
                   $("#addpinball_message").addClass("alert-danger");
                   $("#addpinball_message span").html("There was an error in adding the pinball machine.");
                   $("#addpinball_message").show();
            }
                    
        });
    
        $("#edit_pinball_machine_form").ajaxForm({
          
                   before : function()
                    {
                        $("#addpinball_message").hide(); 
                    },
                    datatype : 'json',
                    success : function(data)
                    {
                        if(data.success === true)
                        {
                            var pinballTable = $("#pinball_table").dataTable();
                            var numberToEdit = -1;
                            $("#pinball_table tbody tr td:nth-of-type(3)").each(function(index){
                                alert(index);
                              if(data.machine.id === $(this).find('button').attr('data-id'))
                              {
                                  numberToEdit = index;
                              }
                            });
                            if(numberToEdit != -1)
                            {
                                var url = pinballMachineUrl.replace(/MACHINE_ID_REPLACE/g, data.machine.id);

                                pinballTable.fnUpdate([
                                    data.machine.name ,
                                    data.machine.description,
                                    "<button data-id='" + data.machine.id + "'   class='btn btn-info edit_machine_modal'>Edit </button>",
                                    "<a class='btn btn-success' href='" +  url  +"'>View</a>",
                                    "<button data-id='" +data.machine.id + "' class='btn btn-danger pinball_retire'>Retire</button>"
                                    ], numberToEdit);
                                 $("#edit_pinball_machine").modal('toggle');

                            }
                        }
                        else
                        {
                            
                            displayErrorMessages("edit_machine_name", "");       
                            displayErrorMessages("edit_machine_description", "");
                            displayErrorMessages("edit_machine_pic", "");

                            if(typeof data.errors === 'undefined')
                            {
                                data.errors = {};
                                data.errors.name = "";
                                data.errors.description = "";
                                data.errors.picture = "";
                            }
                            data.errors.name = 
                                        (typeof data.errors.name === 'undefined') ? "" : data.errors.name;

                            data.errors.description = 
                                        (typeof data.errors.description === 'undefined') ? "" : data.errors.description;

                            data.errors.picture = 
                                        (typeof data.errors.picture === 'undefined') ? "" : data.errors.picture;

                            displayErrorMessages("edit_machine_name", data.errors.name);       
                            displayErrorMessages("edit_machine_description", data.errors.description);
                            displayErrorMessages("edit_machine_pic", data.errors.picture);
                            
                        }
                    
                        
                        
                        
                    },
                    error: function()
                    {
                        
                    }
               
            
    });
        
        $("#add_score_form").ajaxForm({
            before: function()
            {
                $("#addscore_message").hide();
            },
            datatype : 'json',
            success: function(data)
            {
                if(data.success == true)
                {
                    $("#highscore_table").dataTable().fnAddData([
                        data.score.username ,
                        data.score.score,
                        data.score.datecreated,
                        data.score.machinename,
                        
                        "<button data-id='"+ data.score.id +"' class='btn btn-danger score_delete'>Delete</button>"
                        ]);
                    $("#addscore_message").addClass("alert-success");
                    $("#addscore_message").removeClass("alert-danger");
                    $("#addscore_message span").html("You have successfully add the score.");
                    $("#addscore_message").show();
                    
                    $("#highscore_table tr").each(function(){
                            $(this).find('td:last-of-type').each(function(){
                               
                                   if($(this).hasClass("btncontainer") === false)
                                   {
                                       $(this).addClass('btncontainer');
                                   }
                                
                                });
                            });

                }
                else
                {
                    
                        displayErrorMessages("addscore_score", "");       
                        displayErrorMessages("addscore_time", "");
                        displayErrorMessages("addscore_picture", "");
                        
                        if(typeof data.errors === 'undefined')
                        {
                            data.errors = {};
                            data.errors.score = "";
                            data.errors.time = ""; 
                            data.errors.picture = "";

                        }
                        data.errors.time = 
                                    (typeof data.errors.time === 'undefined') ? "" : data.errors.time;
                       
                        data.errors.score = 
                                    (typeof data.errors.score === 'undefined') ? "" : data.errors.score;

                        data.errors.picture = 
                                    (typeof data.errors.picture === 'undefined') ? "" : data.errors.picture;

                        displayErrorMessages("addscore_score", data.errors.score);       
                        displayErrorMessages("addscore_time", data.errors.time);
                        displayErrorMessages("addscore_picture", data.errors.picture);

               
                    $("#addscore_message").addClass("alert-danger");
                    $("#addscore_message").removeClass("alert-success");
                    $("#addscore_message span").html("There was an error adding the score.");
                    $("#addscore_message").show();

                }
                
            },
            error: function()
            {
                $("#addscore_message").addClass("alert-danger");
                $("#addscore_message").removeClass("alert-success");
                $("#addscore_message span").html("There was an error adding the score.");
                $("#addscore_message").show();
            }
        });
        
        
        $(document).on("click", ".pinball_retire", function(){
            var id = $(this).attr('data-id');
            var btn = $(this);
            var pinballmachinestatus = pinballstatusURL.replace(/MACHINE_ID/g, id);
            $.ajax({
               url: pinballmachinestatus,
               type: 'GET',
               datatype: 'json',
               success: function(data)
               {
                 if(data.success == true)
                 {
                     if(data.isActive == true)
                     {
                         btn.removeClass('btn-success');
                         btn.addClass('btn-danger');
                         btn.html('Deactivate');
                     }
                     else
                     {
                         btn.addClass('btn-success');
                         btn.removeClass('btn-danger');
                         btn.html('Activate');
   
                     }
                 }
                 else
                 {
                     alert("There was an error trying to deactivate the pinball machine.");
                 }
                 
               },
               error: function()
               {
                   alert("There was an error trying to deactivate the pinball machine.");
               }
               
            });
        });
        
        /** User Tables Ajax Calls **/
        
        $(".hideAlert").on("click", function(){
           $(this).parent().hide(); 
        });
        
       
        //User Table
        $(document).on('click', ".user_admin",function(){
             var data = {'id' : $(this).attr("data-userid") };
             var btn  = $(this);
             console.log(data);
             console.log(adminChangeUrl);
             $.ajax({
               url : adminChangeUrl,
               type: "post",
               data: data,
               datatype: 'json',
               success: function(data)
               {
                   console.log(data);
                   
                   var div = $("#usertable_message");
                   if(data.success == true)
                   {
               
                       div.removeClass('alert-danger');
                       div.addClass('alert-success');
                       div.show();
                       if(data.isAdmin === true)
                       {
                             div.find('span').html("You have successfully make the user admin.");
                             btn.removeClass('btn-success').addClass('btn-danger').html("Remove Admin");
                       }
                       else
                       {
                             div.find('span').html("You have successfully taken away admin role.");
                             btn.removeClass('btn-danger').addClass('btn-success').html("Make Admin");
                       }
                   }
                   else
                   {
                       div.removeClass('alert-success');
                       div.addClass('alert-danger');
                       div.show();
                       div.find('span').html("Error trying to change role.");
                   }
                           
                           
               },
               error: function()
               {
                       var div = $("#usertable_message");
                       div.removeClass('alert-success');
                       div.addClass('alert-danger');
                       div.show();
                       div.find('span').html("Error trying to change role.");

               }
           }); 
       
        });
        
        $(document).on("click",".user_disable", function(){
            var data = {'id' : $(this).attr("data-userid") };
            var btn  = $(this);
           $.ajax({
               url : enableUrl,
               type: "post",
               data: data,
               datatype: 'json',
               success: function(data)
               {
                   console.log(data);
                   var div = $("#usertable_message");
                   if(data.success == true)
                   {
                       div.removeClass('alert-danger');
                       div.addClass('alert-success');
                       div.show();
                       if(data.enabled === true)
                       {
                             div.find('span').html("You have successfully enabled the user.");
                             btn.removeClass('btn-success').addClass('btn-danger').html("Disable User");
                       }
                       else
                       {
                             div.find('span').html("You have successfully disabled the user.");
                             btn.removeClass('btn-danger').addClass('btn-success').html("Enabled User");
                       }
                   }
                   else
                   {
                       div.removeClass('alert-success');
                       div.addClass('alert-danger');
                       div.show();
                       div.find('span').html("Error enabling or disabling user.");
                   }
                           
                           
               },
               error: function()
               {
                       var div = $("#usertable_message");
                       div.removeClass('alert-success');
                       div.addClass('alert-danger');
                       div.show();
                       div.find('span').html("Error enabling or disabling user.");

               }
           }); 
        });
        
        $(document).on("click",".user_resetpassword", function()
        {
             var data = {'id' : $(this).attr("data-userid") };
                    $.ajax({
                           url : resetPasswordUrl,
                           type: "post",
                           data: data,
                           datatype: 'json',
                           success: function(data)
                           {
                               var div = $("#usertable_message");
                               if(data.success == true)
                               {
                                   div.removeClass('alert-danger');
                                   div.addClass('alert-success');
                                   div.show();
                                   div.find('span').html("You have successfully sent an email to reset the user's password.");
                               }
                               else
                               {
                                   div.removeClass('alert-success');
                                   div.addClass('alert-danger');
                                   div.show();
                                   div.find('span').html("Error resetting user password.");
                               }


                           },
                           error: function()
                           {
                                   var div = $("#usertable_message");
                                   div.removeClass('alert-success');
                                   div.addClass('alert-danger');
                                   div.show();
                                   div.find('span').html("Error resetting user password.");

                           }
                       }); 
        });
    
    
    
        $(document).on("click", ".score_delete", function(){
            var id = $(this).attr('data-id');
            var urlajax = deleteScore.replace(/MACHINE_ID/g, id);
            $.ajax({
                url: urlajax,
                type: 'GET',
                datatype: 'json',
                success: function(data)
                {
                    if(data.success == true)
                    {
                        $("#highscore_table tbody tr td:nth-of-type(5) button").each(function(index){
                            
                          var idOfButton = $(this).attr('data-id'); 
                          console.log($(this));
                          console.log(idOfButton + " == " + data.deleteId);
                          if(idOfButton == data.deleteId )
                          {
                               var oTable =  $("#highscore_table").dataTable();
                                var target_row = $(this).closest("tr").get(0); // this line did the trick
                                var aPos = oTable.fnGetPosition(target_row); 
                                oTable.fnDeleteRow(aPos);                              
                          }
                        });
                    }
                }
            });
        });
    
        //Pinball Highscore Table
    
        $(document).on('click', '.edit_machine_modal', function(){
            var machine_id = $(this).attr('data-id');
            var getpinballmachineurl = getmachineURL.replace(/MACHINE_ID/g, machine_id);
            $("#edit_pinball_machine").modal('toggle');
            
            $("#machine_id").val(machine_id);
            $.ajax({
               url: getpinballmachineurl,
               type: "GET",
               datatype: 'json',
               success: function(machine)
               {
                 $("#edit_machine_name input").val(machine.name);
                 $("#edit_machine_description textarea").val(machine.description);
                 console.log(machine);
               }
            });
        });
                
        function displayErrorMessages(idName, message)
        {
            if(typeof message === 'undefined' || message === "")
            {
                var divUserNameContainer = $("#" + idName);
                divUserNameContainer.removeClass("has-error");
                divUserNameContainer.find('span.help-inline').html("");
                divUserNameContainer.find("span.help-inline").hide();
                divUserNameContainer.find("span.glyphicon-remove").hide();
                
            }
            else
            {
                var divUserNameContainer = $("#" + idName);
                divUserNameContainer.addClass("has-error");
                divUserNameContainer.find("span.help-inline").show();
                divUserNameContainer.find("span.glyphicon-remove").show();
                divUserNameContainer.find('span.help-inline').html(message[0]);
            }
       }
       
       $(document).on("focus","textarea, input",function(){
          $(this).parents("div.has-error").find('span.help-inline').hide();
          $(this).parents("div.has-error").find('span.glyphicon-remove').hide();
          $(this).parents("div.has-error").removeClass('has-error');

       });
});