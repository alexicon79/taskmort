$(document).ready(function () {
	
	var items = $(".item");
	var visibleItems = $(".visible");
	var completedTasks = $(".task_completed");
	var deleteList = $(".deleteList");
	var itemInputFields = $(":input:not(textarea)");
	var addItem = $("#addItem");
	var removeItem = $(".removeItem");
	var removeNote = $(".removeItem_note");
	var checkBox;
	var REGEX_Done = /@done/;
	// var REGEX_Project = /^(?!-)(.+\:)$/i;
	// var REGEX_Note = /^(?!-)(.+)(?!\:)$/i;
	// 
	
	console.log(deleteList);

	generateMarkupFromClassName(items);

	var checkBox = $(".checkBox");
	var checkBox_completed = $(".checkBox_completed");

	visibleItems.click(function(e){
		var item = $(e.target);
		var itemInputField = $(e.target).next()[0];

		itemInputField.className = "visible editableTask";
		item.attr("class", "hidden");

		itemInputField.focus();
	});

	itemInputFields.blur(function(e){
		var itemInput = $(e.target);
		var item = itemInput[0].previousSibling;
		var originalInputString = itemInput.val()
		var cleanString = originalInputString.replace(/<[^>]+>[^<]*<[^>]+>|<[^\/]+\/>/ig, "");

		itemInput[0].className = "hidden";

		if ($(item).hasClass("task_completed")) {
			item.className = "visible task_completed";
		} else {
			item.className = "visible";			
		}

		item.innerHTML = cleanString;

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

		$("<li class='newItem'><input type='text' class='editableTask' name='item[]' placeholder='Add new item...' value=''><span id='syntax'>[Syntax?]</span></li>").prependTo(ulList);
		
		$(".editableTask")[0].focus();

		var syntaxButton = $("#syntax");
		syntaxButton.click(function(e){
			e.target.innerHTML = "Begin with a single dash [-] to create a task. End with a semi-colon [:] to create a project. Tag with @done if task is completed. Everything else is a note. Off you go!";
		});
	});

	removeItem.click(function(e){
		var submit = $(":submit");
		var item = $(e.target)[0].parentNode;
		item.remove();
		submit.click();
	});

	removeNote.click(function(e){
		var submit = $(":submit");
		var item = $(e.target)[0].parentNode;
		item.remove();
		submit.click();
	});

	deleteList.click(function(e){
		if (confirm('Do you really want to delete this list?')) {
    		return;
		} else {
    		e.preventDefault();
		}
	});

	checkBox.click(function(e){
		var submit = $(":submit");
		var item = $(e.target)[0].parentNode;
		var itemInput = $(item)[0].firstChild.nextSibling;
		itemInput.value = itemInput.value + " @done";
		submit.click();
	});

	checkBox_completed.click(function(e){
		var submit = $(":submit");
		var item = $(e.target)[0].parentNode;
		var itemInput = $(item)[0].firstChild.nextSibling;
		
		var originalString = itemInput.value;

		var cleanString = originalString.replace(/@done/ig, "");

		itemInput.value = cleanString;
		submit.click();
	});

	$(function() {
		$( "ul.listView" ).sortable({
			revert: true
		});

		$( "span, ul, li" ).disableSelection();
	});

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