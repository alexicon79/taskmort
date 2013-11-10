$(document).ready(function () {
	
	var items = $(".item");
	var visibleItems = $(".visible");
	var editButton = $("#edit");
	var viewButton = $("#view");
	var completedTasks = $(".task_completed");
	var deleteList = $(".deleteList");
	var itemInputFields = $(":input:not(textarea, #listName, .loginForm, .loginCheckbox, .loginSubmit, #saveAndView, #saveToDropbox)");
	var addItem = $("#addItem");
	var removeItem = $(".removeItem");
	var removeNote = $(".removeItem_note");
	var removeProject = $(".removeItem_project");
	var checkBox;
	var REGEX_Done = /@done/;

	generateMarkupFromClassName(items);

	var checkBox = $(".checkBox");
	var checkBox_completed = $(".checkBox_completed");

	visibleItems.click(function(e){
		//todo: fix e.target so it inlcudes entire string. thats probably why multiple tags doesn't work
		var item = $(e.target);
		console.log(item);
		var itemInputField = $(e.target).next()[0];

		itemInputField.className = "visible editableTask";
		item.attr("class", "hidden");

		itemInputField.focus();
	});

	itemInputFields.blur(function(e){
		var itemInput = $(e.target);
		var item = itemInput[0].previousSibling;
		var originalInputString = itemInput.val();
		var cleanString = originalInputString.replace(/<[^>]+>[^<]*<[^>]+>|<[^\/]+\/>/ig, "");
		var taggedString = cleanString.replace(/@.[^ ]*/ig, "<span class='tag'>$&</span>");

		itemInput[0].className = "hidden";

		if ($(item).hasClass("task_completed")) {
			item.className = "visible task_completed";
		} else {
			item.className = "visible";
		}

		item.innerHTML = taggedString;

		generateMarkupFromClassName(item);

	});

	itemInputFields.keypress(function(e) {
		if(e.which === 13) {
			this.blur();
		}
	});

	addItem.click(function(e){
		e.preventDefault();
		var ulList = $("ul.listView");

		$("<li class='newItem'><div id='addItemWrapper'><input type='text' class='editableTask' name='item[]' placeholder='Add new item...' value=''><a id='addItemButton' href='#'>OK</a></div><span id='syntax'>[Syntax?]</span></li>").prependTo(ulList);
		$(".editableTask")[0].focus();

		var addItemButton = $("#addItemButton");

		addItemButton.click(function(e){
			e.preventDefault();
			var submit = $(":submit");
			submit.click();
		});

		var syntaxButton = $("#syntax");
		syntaxButton.click(function(e){
			e.target.innerHTML = "Begin with a single dash [-] to create a task. End with a colon [:] to create a project. Tag with @done if task is completed. Everything else is a note. Off you go!";
		});
	});

	editButton.click(function(e){
		submitForm();
	});

	removeItem.click(function(e){
		var item = $(e.target)[0].parentNode;
		item.remove();
		submitForm();
	});

	removeNote.click(function(e){
		var item = $(e.target)[0].parentNode;
		item.remove();
		submitForm();
	});

	removeProject.click(function(e){
		var item = $(e.target)[0].parentNode;
		item.remove();
		submitForm();
	});

	deleteList.click(function(e){
		if (confirm('Do you really want to delete this list?')) {
    		return;
		} else {
    		e.preventDefault();
		}
	});

	checkBox.click(function(e){
		var item = $(e.target)[0].parentNode;
		var itemInput = $(item)[0].firstChild.nextSibling;
		itemInput.value = itemInput.value + " @done";
		submitForm();
	});

	checkBox_completed.click(function(e){

		var item = $(e.target)[0].parentNode;
		var itemInput = $(item)[0].firstChild.nextSibling;
		
		var originalString = itemInput.value;

		var cleanString = originalString.replace(/@done/ig, "");

		itemInput.value = cleanString;

		submitForm();
	});

	$(function() {
		$( "ul.listView" ).sortable({
			stop: function( event, ui ) {
				submitForm();
			},
			revert: true
		});

		$( "span, ul, li" ).disableSelection();
	});

	function submitForm() {
		var submit = $(":submit");
		submit.click();
	};

	function generateMarkupFromClassName(content) {
		for (var i = 0; i < content.length; i++) {
			if (REGEX_Done.test(content[i].textContent)) {
				content[i].className = "item task_completed";
				$(content[i]).append("<span class='checkBox_completed'>&#9679;</span>");
			} else if (content[i].className === "item task") {
				$(content[i]).append("<span class='checkBox'>&#9675;</span>");
			}
		};
	};
});