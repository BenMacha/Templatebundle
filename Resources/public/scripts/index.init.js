jQuery(function () {
    "use strict";

    function initSparklines() {
        $dash.find(".sparkline").sparkline("html", {enableTagOptions: !0, tagOptionsPrefix: "data-"})
    }

    function initC3Chart() {
        var analyticsconfig = {
            bindto: "#c3chartAnalytics",
            data: {
                columns: [["Network Load", 30, 100, 80, 140, 150, 200], ["CPU Load", 90, 100, 170, 140, 190, 50]],
                type: "spline",
                types: {"Network Load": "bar"}
            },
            color: {pattern: ["#3F51B5", "#38B4EE", "#4CAF50", "#E91E63"]},
            legend: {position: "inset"},
            size: {height: 330}
        }, browserconfig = {
            bindto: "#c3chartbrowsershare",
            data: {
                columns: [["Chrome", 48.9], ["Firefox", 16.1], ["Safari", 10.9], ["IE", 17.1], ["Other", 7]],
                type: "donut"
            },
            size: {width: 260, height: 260},
            donut: {width: 50},
            color: {pattern: ["#3F51B5", "#4CAF50", "#f44336", "#E91E63", "#38B4EE"]}
        };
        c3.generate(analyticsconfig), c3.generate(browserconfig)
    }

    function initEasyPieChart() {
        var charts = [{
            selector: ".easypiechart.storageOpts",
            options: {size: 100, lineWidth: 2, lineCap: "square", barColor: "#E91E63"}
        }, {
            selector: ".easypiechart.serverOpts",
            options: {size: 100, lineWidth: 2, lineCap: "square", barColor: "#4CAF50"}
        }, {
            selector: ".easypiechart.clientOpts",
            options: {size: 100, lineWidth: 2, lineCap: "square", barColor: "#FDD835"}
        }];
        charts.forEach(function (chart) {
            $(chart.selector).easyPieChart(chart.options)
        })
    }

    function initRating() {
        $("input.rating-control").rating()
    }

    function TodoApp() {
        function addTodoHtml(todo, index) {
            var html = '<li data-index="' + index + '" class="' + (todo.completed ? "completed" : "") + '">					<div class="ui-checkbox ui-checkbox-pink">	    				<label>	    					<input type="checkbox" class="toggle" ' + (todo.completed ? "checked" : "") + '/>	    					<span></span>	    				</label>	    			</div>	    			<div class="todo-title"><p>' + todo.title + '</p><form class="todo-edit">    					<input type="text"/>    				</form>    			</div>    			<span class="destroy ion ion-close right"></span>	    		</li>';
            $todoApp.find(".todo-list").append(html)
        }

        function reArrangeIndex() {
            $todoApp.find(".todo-list > li").each(function (i) {
                $(this).data("index", i)
            })
        }

        function removeTodo() {
            var todo = $(this).parent(), isCompleted = todo.find("input.toggle")[0].checked, todoNo = todo.index();
            todo.remove(), scope.remainingCount -= isCompleted ? 0 : 1, todos.splice(todoNo, 1), todoStore.put(todos), reArrangeIndex(), $todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left")
        }

        function toggleCompleted() {
            var todo = $(this).parents("li"), todoNo = todo.index(), isCompleted = this.checked;
            console.log(todoNo), scope.remainingCount += isCompleted ? -1 : 1, todos[todoNo].completed = isCompleted, todoStore.put(todos), todo.toggleClass("completed"), $todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left")
        }

        function markAll() {
            var $todos = $todoApp.find(".todo-list li"), rc = 0, allChecked = !1;
            todos.forEach(function (todo) {
                todo.completed || ++rc
            }), 0 == rc && (allChecked = !0), todos.forEach(function (todo) {
                todo.completed = !allChecked
            }), scope.remainingCount = allChecked ? 0 : todos.length, todoStore.put(todos), $todos.each(function (i, todo) {
                var $t = $(todo), input = $t.find("input.toggle")[0];
                allChecked ? ($(todo).removeClass("completed"), input.checked = !1) : ($(todo).addClass("completed"), input.checked = !0)
            }), $todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left")
        }

        function addTodo(e) {
            e.preventDefault();
            var todoTitle = $(this).children().val();
            scope.newTodo = todoTitle;
            var newTodo = {title: scope.newTodo.trim(), completed: !1};
            0 != scope.newTodo.length && (todos.push(newTodo), todoStore.put(todos), scope.newTodo = "", scope.remainingCount++, addTodoHtml(newTodo, todos.length - 1), setTimeout(function () {
                $todoApp.find(".todo-list li:last-child .destroy").on("click touchstart", removeTodo)
            }), $(this).children().val(""), $todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left"))
        }

        function doneEditing(todo, todoTitle, isCompleted, todoNo) {
            todo.removeClass("editing"), todoTitle = todoTitle.trim(), todos[todoNo].title = todoTitle, todoTitle || scope.removeTodo(todo, isCompleted, todoNo), todoStore.put(todos), todo.find(".todo-title p").html(todoTitle)
        }

        function editTodo() {
            var todo = $(this).parent(), todoNo = todo.index(), stodo = todos[todoNo], isCompleted = stodo.completed;
            todo.addClass("editing"), $(this).find("input").val(stodo.title.trim()), $todoApp.find(".todo-title .todo-edit").on("submit", function (e) {
                e.preventDefault();
                var todoTitle = $(this).find("input").val();
                doneEditing(todo, todoTitle, isCompleted, todoNo)
            })
        }

        function clearCompleted() {
            todos = todos.filter(function (val) {
                return !val.completed
            }), todoStore.put(todos);
            var $todos = $todoApp.find(".todo-list li").filter(function (i, todo) {
                return $(todo).hasClass("completed")
            });
            $todos.remove()
        }

        var $todoApp = $("#todoApp"), STORAGE_ID = "_todo-task", todoStore = {
            todos: [], get: function () {
                return JSON.parse(localStorage.getItem(STORAGE_ID))
            }, put: function (todos) {
                localStorage.setItem(STORAGE_ID, JSON.stringify(todos))
            }
        }, demoTodos = [{title: "Eat healthy, Eat fresh", completed: !1}, {
            title: "Donate some money",
            completed: !0
        }, {title: "Wake up at 5:00 A.M", completed: !1}, {
            title: "Hangout with friends at 12:00",
            completed: !1
        }, {
            title: "Another todo on the list. Add as many you want.",
            completed: !1
        }, {title: "The last but not the least.", completed: !0}], todos = todoStore.get() || demoTodos, scope = {
            newTodo: "",
            remainingCount: todos.filter(function (val) {
                return 0 == val.completed
            }).length,
            editedTodo: null,
            originalTodo: "",
            statusFilter: null,
            edited: !1,
            todoshow: "all",
            allChecked: !1
        };
        todos.forEach(function (todo, index) {
            addTodoHtml(todo, index)
        }), $todoApp.find(".todo-foot .remaining").html(scope.remainingCount + " left"), $todoApp.find(".destroy").on("click touchstart", removeTodo), $todoApp.find("li input.toggle").on("change", toggleCompleted), $todoApp.find("#input-todo").on("submit", addTodo), $todoApp.find(".todo-title").on("dblclick", editTodo), $todoApp.find(".todo-foot .toggle-all").on("click touchstart", markAll), $todoApp.find(".todo-foot .clear-completed").on("click touchstart", clearCompleted)
    }

    function _init() {
        initSparklines(), initC3Chart(), initEasyPieChart(), initRating(), TodoApp()
    }

    var $dash = $(".page-dashboard");
    _init()
});