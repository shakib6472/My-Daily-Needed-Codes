<?php
class Elementor_certificate_product_loop extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'certificate';
    } 

    public function get_title()
    {
        return esc_html__('Ceritificate', 'spitznagel');
    }

    public function get_icon()
    {
        return 'fas fa-award';
    }
    protected function _register_controls()
    {

    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['certificate'];
    }

    protected function render()
    {
       ?> 
       
       
       <div class="container">

<div class="row">
    <div class="col-md-12 position-relative">
        <div class="spiner">
            <div class="spinning"></div>
            <p class="text mt-5">Finding the Certificate</p>
        </div>


        <div class="validation d-flex align-items-stretch justify-content-center flex-column">
            <div class="form-label">
                <label for="id" class="mb-3">Enter Certificate Id</label>
                <input type="number" class="form-control certificate-id" id="id" placeholder="E.g 154788465487">
                <p class="error text-danger m-0">Please Enter the Certifiate ID</p>
                <div class="btn btn-primary mt-3 verify-check">Verify</div>
            </div>
        </div>
    </div>

</div>
</div>
<div class="ppbox">
<div class="popup-box">
    <div class=" card info mt-4 p-4">
        <div class="informations">
            <h3 class="text-center found-text">Certificate Found</h3>
           
            <table class="w-100 data-table-to-show">
                <tbody>
                    <tr>
                        <td class="font-bold" style="width: 15%;">
                            <p class="text-bold p-0 m-0">Name</p>
                        </td>
                        <td style="width: 2%;">:</td>
                        <td class="font-bold name-p"> </td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="width: 15%;">
                            <p class="text-bold p-0 m-0">DOB</p>
                        </td>
                        <td style="width: 2%;">:</td>

                        <td class="font-bold dob-p"></td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="width: 15%;">
                            <p class="text-bold p-0 m-0">Course Name</p>
                        </td>
                        <td style="width: 2%;">:</td>

                        <td class="font-bold course-p"> </td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="width: 15%;">
                            <p class="text-bold p-0 m-0">Issue date</p>
                        </td>
                        <td style="width: 2%;">:</td>

                        <td class="font-bold issue-p"></td>
                    </tr>
                    <tr>
                        <td class="font-bold" style="width: 15%;">
                            <p class="text-bold p-0 m-0">Expire date</p>
                        </td>
                        <td style="width: 2%;">:</td>

                        <td class="font-bold expire-p"></td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
       <?php 
    }
}