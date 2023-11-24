@include('bookDashboardMenu')

<div class="book_dashboard_header">

        @include('bookDashboardLogo')
        <div class="book_header">
                <button onclick="showMenu()" id="show_menu_list"><img src='{{asset("images/avatar/$teamAvatar")}}' alt="" /></button>
                <div class="book_header_id">
                        <span class="book_header_teamName">{{$teamName}}</span>
                        <span class="book_header_teamId">#{{$teamId}}</span>
                </div>
        </div>

        <div class="book_date_switch">
                <form action="{{route('validate_book_dashboard')}}" method="POST" id='dateForm'>
                        @csrf
                        <label for="all" class="book_date_all"><input type="radio" name='date_switch' id='all' value="all" {{
                                Request::is("book_dashboard/$teamId/all") ? 'checked' : '' }} />全て</label>
                        <label for="year" class="book_date_year"><input type="radio" name='date_switch' id='year' value="year" {{
                                Request::is("book_dashboard/$teamId/year") ? 'checked' : '' }} />年次</label>
                        <label for="month" class="book_date_month"><input type="radio" name='date_switch' id='month' value="month" {{
                                Request::is("book_dashboard/$teamId/month") ? 'checked' : '' }} />月次</label>
                        
                        <input name='teamId' value="{{$teamId}}" hidden />
                </form>
        </div>

        @if(isset($book))
        <span>gssdfsdf</span>
        @else
        @include('noBookRegister')
        @endif
</div>
<div class="menu_background" id='menu_background'></div>

<script>
    let startX;
    function handleDrag(event){
        startX = event.clientX;
        event.dataTransfer.setData("text/plain", startX);
        console.log(startX);
    }
    var menu_back = document.getElementById('menu_background');
    document.getElementById('book_dashboard_menu_container').addEventListener('drag', function (event) {
                const deltaX = event.clientX - startX;
                if((Math.abs(deltaX)) >280){
                    menu_back.style.opacity = '0';
                setTimeout(() => {
                    menu_back.style.display = 'none';
                }, .3);
                            document.getElementById('book_dashboard_menu_container').style.transform = 'translate(-353px,0)';
                        }
                });
    function showMenu(){
        var menu = document.getElementById('book_dashboard_menu_container');
        var menu_back = document.getElementById('menu_background');
        setTimeout(() => {
            menu_back.style.opacity = '1';
            menu_back.style.display = 'block';
        }, .3);
        menu.style.transform = 'translate(0,0)';
    }
        document.addEventListener('DOMContentLoaded', function () {
            var dateForm = document.getElementById('dateForm');
            var menu_back = document.getElementById('menu_background');
            var menu = document.getElementById('book_dashboard_menu_container');

            menu_back.addEventListener('click', function(){
                menu_back.style.opacity = '0';
            menu.style.transform = 'translate(-353px,0)';

                setTimeout(() => {
                    menu_back.style.display = 'none';
              }, .5);  
            })

                var dateSwitches = document.querySelectorAll('input[name="date_switch"]');
                dateSwitches.forEach(function (switchInput) {
                        if (switchInput.checked) {
                            var label = switchInput.parentNode;
                            label.classList.add('date_active');
                        } else {
                            var label = switchInput.parentNode;
                           if(label.classList.contains('data_active')){
                            label.classList.remove('data_active')
                           }
                        }
                });
                dateForm.addEventListener('change', function (event) {
                        if (event.target.type == 'radio') {
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