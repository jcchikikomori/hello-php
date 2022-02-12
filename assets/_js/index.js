// We can import dependencies/bundles here
require("@vizuaalog/bulmajs")
const dayjs = require("dayjs")

// Load JQuery manually
import $  from "jquery"
window.$ = window.jQuery = $

// onReady from jQuery
$(function() {
  console.log('hello world')

  // or $(".alert .close").on("click", function() {..
  // $(".alert .close").on("click", () => {
  //   $(".alert .close").parent().hide()
  // })
})