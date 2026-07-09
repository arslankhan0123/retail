<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php print $SITE_TITLE; ?> | Log in</title>
  <link rel='shortcut icon' href='<?php echo $theme_link; ?>images/favicon.ico' />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $theme_link; ?>plugins/iCheck/square/blue.css">
  <?php
  $lang = trim(strtoupper($this->session->userdata('language')));
  if ($lang == strtoupper('arabic') || $lang == strtoupper('urdu')) { ?>
    <!-- RTL For arabic styles -->
    <link rel="stylesheet" href="<?php echo $theme_link; ?>bootstrap/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="<?php echo $theme_link; ?>dist/css/AdminLTE.rtl.min.css">
  <?php } ?>
  <style>
    /* body.login-page {
      background: #DDE7FC !important;
    } */

    .login-logo-inside {
      text-align: center;
      margin-bottom: 25px;
    }

    .login-logo-inside img {
      width: 80%;
      height: 80%;
      object-fit: contain;
      display: block;
      margin: 0 auto;
    }

    .login-box-body {
      background: #73b3f5 !important;
      /* background: #c7d9ff !important; */
      /* background: #a8c5ff !important; */
      /* background: #dbeafe !important; */
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      padding: 30px;
    }

    .login-box {
      width: 850px;
    }

    .login-box-body {
      display: flex;
      min-height: 450px;
      /* Adjust as needed */
      padding: 0;
      border-radius: 22px;
      overflow: hidden;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
      background: #fff;
    }

    /* Left Section - Rapid Logo */
    .logo-section {
      width: 50%;
      background: #28ACE2;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 30px;
      text-align: center;
    }

    .logo-section img {
      max-width: 100%;
      height: auto;
    }

    /* Right Section - Login Form */
    .form-section {
      width: 50%;
      background: #ffffff;
      padding: 40px 30px;
    }

    .login-box-msg {
      font-size: 18px;
      font-weight: 600;
      margin-bottom: 25px;
      text-align: center;
    }

    .btn-primary {
      background: #28ACE2;
      border-color: #28ACE2;
      border-radius: 15px !important;
    }

    .btn-primary:hover {
      background: #1880cb;
      border-color: #1880cb;
    }

    @media(max-width:768px) {
      .login-box {
        width: 95%;
      }

      .login-box-body {
        flex-direction: column;
      }

      .logo-section,
      .form-section {
        width: 100%;
      }

      .logo-section {
        min-height: 180px;
      }
    }

    .password-wrapper {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      right: 12px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
      color: #28ACE2;
      font-size: 16px;
      z-index: 10;
    }

    .password-toggle:hover {
      color: #1880cb;
    }

    .welcome_back {
      margin-bottom: 0px !important;
      padding: 0 0 0 0;
    }

    .login-box-msg {
      color: #28ACE2;
    }

    .erp-title {
      margin-top: 20px;
      color: #fff;
      font-size: 100px;
      font-weight: 700;
      letter-spacing: 3px;
    }
  </style>
</head>

<body class="hold-transition login-page">

  <!-- language -->
  <!-- <input type="hidden" id="base_url" value="<?= base_url() ?>"> -->
  <!-- <?php $this->load->view('comman/language.php'); ?> -->
  <!-- language end -->

  <div class="login-box">

    <!-- /.login-logo -->
    <div class="login-box-body">

      <!-- Left Section -->
      <div class="logo-section">
        <img src="<?php echo base_url(); ?>theme/images/logo.png" alt="Rapid Logo">

        <h1 class="erp-title">ERP</h1>
      </div>

      <!-- Right Section -->
      <div class="form-section">

        <p class="login-box-msg welcome_back">
          <?= $this->lang->line('welcome_back'); ?>
        </p>
        <p class="login-box-msg">
          <?= $this->lang->line('sign_in_message'); ?>
        </p>

        <div class="text-danger tex-center">
          <?php echo $this->session->flashdata('failed'); ?>
        </div>

        <div class="text-success tex-center">
          <?php echo $this->session->flashdata('success'); ?>
        </div>

        <form id="login-form" action="<?php echo $base_url; ?>login/verify" method="post">

          <input type="hidden"
            name="<?php echo $this->security->get_csrf_token_name(); ?>"
            value="<?php echo $this->security->get_csrf_hash(); ?>">

          <div class="form-group has-feedback">
            <input type="text" class="form-control"
              placeholder="Email" id="email" name="email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback password-wrapper">
            <input type="password"
              class="form-control"
              placeholder="Password"
              id="pass"
              name="pass">

            <span id="togglePassword"
              class="fa fa-eye password-toggle"></span>
          </div>

          <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-6">
              <label style="font-weight:normal; cursor:pointer;">
                <input type="checkbox" name="remember_me" value="1">
                Remember Me
              </label>
            </div>
            <div class="col-xs-6 text-right">
              <a href="<?= base_url('login/forgot_password') ?>">
                <?= $this->lang->line('forgot_password'); ?>
              </a>
            </div>
            <?php if (store_module()) { ?>
              <div class="col-xs-6">
                <a href="<?= base_url('register') ?>">
                  <?= $this->lang->line('register'); ?>
                </a>
              </div>
            <?php } ?>
          </div>

          <button type="submit"
            class="btn btn-primary btn-block btn-flat mt-2">
            <?= $this->lang->line('login_in'); ?>
          </button>

        </form>

      </div>

    </div>
    <!-- /.login-box-body -->
    <?php if (demo_app()) { ?>
      <div class="box-body">
        <label>Click to Start Session!</label>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-bordered table-condensed text-center">
              <tr>
                <td>admin@example.com</td>
                <td>123456</td>
                <td><button type="button" class="btn btn-info btn-block btn-flat admin">Apply</button></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
        <i><i class="fa fa-fw fa-info-circle text-warning"></i>Some of the features are disabled in demo and it will be reset after each hour.</i>
      </div>
    <?php } ?>


  </div>

  <!-- /.login-box -->

  <!-- jQuery 2.2.3 -->
  <script src="<?php echo $theme_link; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
  <!-- Bootstrap 3.3.6 -->
  <script src="<?php echo $theme_link; ?>bootstrap/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="<?php echo $theme_link; ?>plugins/iCheck/icheck.min.js"></script>
  <script src="<?php echo $theme_link; ?>js/language.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
  <script type="text/javascript">
    $(function($) { // this script needs to be loaded on every page where an ajax POST may happen
      $.ajaxSetup({
        data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        }
      });
    });
  </script>
  <script type="text/javascript">
    $(".admin").on("click", function(event) {
      $("input[name='email']").val("admin@example.com");
      $("input[name='pass']").val("123456");
      $("#login-form").submit();
    });
  </script>
  <script>
    $('#togglePassword').on('click', function() {
      let passwordField = $('#pass');

      if (passwordField.attr('type') === 'password') {
        passwordField.attr('type', 'text');
        $(this).removeClass('fa-eye').addClass('fa-eye-slash');
      } else {
        passwordField.attr('type', 'password');
        $(this).removeClass('fa-eye-slash').addClass('fa-eye');
      }
    });
  </script>
</body>

</html>