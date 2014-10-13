<?php
include_once("page.php");
include_once("sqlWord.php");

class pageStatistics extends Page
{
    /**
     * Returns script name to be included into index file
     *
     * @return string <script> tag
     */
    public function getScript()
    {
        return '
            <script src="js/statistics.js"></script>
            <script src="fw/flot/jquery.flot.pie.js"></script>';
    }


    /**
     * @return string
     */
    public function getContent()
    {
        $content = '
            <div class="col-sm-6 col-md-6 col-lg-6">
                <h3>Статистика</h3>
                <div id="graph1"></div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6">
                <h3>Статистика</h3>
                <div id="graph2"></div>
            </div>';

        return $content;
    }
}

?>