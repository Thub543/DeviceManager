
<!-- Footer -->
<footer class="page-footer mt-auto" id="footer-main">

  <!-- Footer Links -->
  <div class="container text-center text-md-left">

    <!-- Grid row -->
    <div class="row" id="footer-row">

      <!-- Grid column -->
      <div class="col-md-3" id="left-footer-side">

        <img class="img-fluid" src="{{ asset('images/icons8-platzhalter-100.png') }}" id="footer-logo">

      </div>
      <!-- Grid column -->

      <!-- Grid column -->
      <div class="col-md-3" id="secleft-footer-side">

        <ul id="left-footer-list">
          <li>
            <h5 id="left-footer-list-h">DeviceManger</h5>
          </li>
          <li>
            <p id="left-footer-list-text">Address</p>
          </li>
          <li>
            <p id="left-footer-list-text-2">PostCode</p>
          </li>
        </ul>

      </div>

      <div class="col-md-3" id="right-footer-side">

        <ul id="right-footer-list">
          <li>
            <a href=" {{ route('devices.create') }}" id="right-footer-list-h">Add Device</a>
          </li>
          <li>
            <a href=" {{ route('handovers.create') }}" id="right-footer-list-text">Onboarding</a>
          </li>
          <li>
            <a href=" {{ route('activeHandovers') }}" id="right-footer-list-text-2">Return Device</a>
          </li>
        </ul>

      </div>

      <div class="col-md-3" id="secright-footer-side">

        <ul id="secright-footer-list">
          <li>
            <a href=" {{ route('orders.index') }}" id="right-footer-list-h">Orders</a>
          </li>
          <li>
            <a href=" {{ route('handovers.index') }}" id="right-footer-list-text-2">All Handovers</a>
          </li>
            <li>
                <a href=" {{ route('logout') }}" id="right-footer-list-text">Logout</a> (Logged in as {{ Auth::user()->username }})
            </li>
        </ul>

      </div>
      <!-- Grid column -->

    </div>
    <!-- Grid row -->

  </div>
  <!-- Footer Links -->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3" id="bottom-footer-line">© 2023 Copyright
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
