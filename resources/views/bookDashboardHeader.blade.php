
<div class="book_dashboard_header">

   @include('bookDashboardLogo')
   <div class="book_header">
    <img src="" alt="" />
    <div class="book_header_id">
        <span class="book_header_teamName"></span>
        <span class="book_header_teamId"></span>
    </div>
    <div class="book_date_switch">
        <form action="{{route('validate_book_dashboard')}}" method="POST" id='dateForm'>
            @csrf
            <input type="radio" name='date_switch' id='all' value="all" {{ Request::is("book_dashboard/$teamId/all") ? 'checked' : '' }}/>
            <input type="radio" name='date_switch' id='year' value="year"{{ Request::is("book_dashboard/$teamId/year") ? 'checked' : '' }}/>
            <input type="radio" name='date_switch'id='month' value="month"{{ Request::is("book_dashboard/$teamId/month") ? 'checked' : '' }}/>
            <input name = 'teamId' value = "{{$teamId}}" hidden />
        </form>
    </div>
    <div class="book_date_content">
        <label for="all">全て</label>
        <label for="year">年次</label>
        <label for="month">月次</label>
    </div>
    @if(isset($book))
        <span>gssdfsdf</span>
    @else
        @include('noBookRegister')
    @endif
    </div>

   </div>

   <script>
    document.addEventListener('DOMContentLoaded',function(){
        var dateForm = document.getElementById('dateForm');
        var dateSwitches = document.querySelectorAll('input[name="date_switch"]');
        dateSwitches.forEach(function (switchInput) {
        if (switchInput.checked) {
            console.log(switchInput.checked);
            switchInput.className = 'date_active';
        }else{
            switchInput.className = 'date_inactive';
        }
            });
        dateForm.addEventListener('change',function (event){
            if(event.target.type=='radio'){
                var option = event.target.value;
                dateForm.submit();
            }
        })
    });
    </script>
    

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dateSwitches = document.querySelectorAll('input[name="date_switch"]');

        dateSwitches.forEach(function (switchInput) {
            switchInput.addEventListener('change', function (event) {
                dateSwitches.forEach(function (otherSwitch) {
                    // Set class to 'active' if the current switch is checked, 'ggg' otherwise
                    otherSwitch.classList.toggle('active', otherSwitch === event.target && event.target.checked);
                    otherSwitch.classList.toggle('ggg', otherSwitch !== event.target || !event.target.checked);
                });
            });
        });
    });
</script>
