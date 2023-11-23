
<div class="book_dashboard_header">

   @include('bookDashboardLogo')
   <div class="book_header">
    <img src="" alt="" />
    <div class="book_header_id">
        <span class="book_header_teamName"></span>
        <span class="book_header_teamId"></span>
    </div>
    <div class="book_date_switch">
        <form  id='dateForm'>

            <input type="radio" name='date_switch' id='all' value="all" {{ Request::is('book_dashboard/all') ? 'checked' : '' }}/>
            <input type="radio" name='date_switch' id='year' value="year"{{ Request::is('book_dashboard/year') ? 'checked' : '' }}/>
            <input type="radio" name='date_switch'id='month' value="month"{{ Request::is('book_dashboard/month') ? 'checked' : '' }}/>
        </form>
    </div>
    <div class="book_date_content">
        <label for="all">全て</label>
        <label for="year">年次</label>
        <label for="month">月次</label>
    </div>
    </div>

   </div>

   <script>
    document.addEventListener('DOMContentLoaded',function(){
        var dateForm = document.getElementById('dateForm');
        dateForm.addEventListener('change',function (event){
            if(event.target.type=='radio'){
                var option = event.target.value;
                switch(option){
                    case "all":
                        window.location.href = '/book_dashboard/all';
                        break;
                        case "year":
                        window.location.href = '/book_dashboard/year';
                        break;
                        case "month":
                        window.location.href = '/book_dashboard/month';
                        break;
                }
            }
        })
    });
    </script>