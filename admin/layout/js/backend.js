$(function () {
  "use strict";

  //Hide placeholder on form focus
  $("[placeholder]")
    .focus(function () {
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  //Add Asterisk on required field
  $("input").each(function () {
    if ($(this).attr("required") === "required") {
      $(this).after('<span class="asterisk">*</span>');
    }
  });

  //Convert Passowrd field to text field
  var passField = $(".password");
  $(".show-pass").hover(
    function () {
      passField.attr("type", "text");
    },
    function () {
      passField.attr("type", "password");
    }
  );

  //confirmation message  on Button
  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });
});
