<!-- <form>
  <div class="input-group col-md-6 mobile-search-bar">
      <span class="input-group-addon" style="background-color: #1f4177; border-radius: 25px 0px 0px 25px;"><i class="fa fa-search"></i></span>
      <input type="text" name="search_box" id="search_box" placeholder="Search by Name, Post Title, Job Role, Job Location" data-toggle="tooltip" title="Search by Name, Post Title, Job Role, Job Location" class="form-control" autocomplete="off"><img src="../../assets/images/cross.png" class="cross-img">
  </div>
</form> -->
<style>
form.example input[type=text] {
    padding: 15px;
    /*border: 1px solid grey;*/
    float: left;
    width: 90%;
    background-color: #fff;
    margin-left: -25px;
    /*border-left: none;
    border-radius: 25px 0px 0px 25px;*/
}

form.example button {
  margin: 0px auto;
    height: 34.5px;
    float: left;
    width: 18%;
    padding: 0px;
    background: #1f4177;
    color: #fff;
    cursor: pointer;
    border-left: none;
    border: 1px solid grey;
    border-radius: 0px 25px 25px 0px;
}

form.example button:hover {
  background: #1f4177;
  color: #fff;
}

form.example::after {
  content: "";
  clear: both;
  display: table;
}

.collapsible {
  cursor: pointer;
}
.content {
    padding: 0 18px;
    display: none;
    overflow: hidden;
    border: 1px solid #f1f1f1;
    padding: 5px;
    width: 195%;
    margin: 20px -510px;
} 
#lblError{
    margin-left: 15px;
}

#postModal{
    z-index: 5000;
}
</style>
<form class="example" action="../search/" method="POST">
  <div class="col-md-4">
    <select name="search_type" class="form-control search_type" required>
      <option value="all" <?php if(isset($_POST['search_type'])){ $searchType = $_POST['search_type']; if($searchType == 'all'){ ?> selected="selected" <?php } }?>>Any</option>
      <option value="post_name" <?php if(isset($_POST['search_type'])){ $searchType = $_POST['search_type']; if($searchType == 'post_name'){ ?> selected="selected" <?php } }?>>Recruiter Name </option>
      <option value="candidate_name" <?php if(isset($_POST['search_type'])){ $searchType = $_POST['search_type']; if($searchType == 'candidate_name'){ ?> selected="selected" <?php } }?>>Candidate Name </option>
      <option value="title" <?php if(isset($_POST['search_type'])){ $searchType = $_POST['search_type']; if($searchType == 'title'){ ?> selected="selected" <?php } }?>>Job Title </option>
      <option value="location" <?php if(isset($_POST['search_type'])){ $searchType = $_POST['search_type']; if($searchType == 'location'){ ?> selected="selected" <?php } }?>>Job Location </option>
    </select>
  </div>
  <div class="col-md-8">
    <input type="text" name="search" placeholder="Search by Name, Post Title, Job Role, Job Location" data-toggle="tooltip" value="<?php if(isset($_POST['search'])){ $search = $_POST['search']; echo $search; }else{ echo ""; } ?>" onkeyup="this.value=this.value.replace(/[^a-zA-Z0-9]/g, ' ')" title="Search by Name, Post Title, Job Role, Job Location" class="form-control search" autocomplete="off" required><?php if(isset($_POST['search'])){ ?> <img src="../../assets/images/cross.png" class="cross-img"> <?php } ?>
    <button type="submit" class="search-btn" value="Search">Search<!-- <i class="fa fa-search"></i> --></button>
  </div>
</form>
<span id="lblError" style="color: red"></span>
<script>
  $(document).ready(function(){
    if($("#search_box").val() != ''){
      $(".cross-img").show();
    }
  });

  $(".cross-img").on('click', function(){
    window.location.href = "../home/";
  });

  /*$(".search").keyup(function(){
      if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
          $("#lblError").html("Enter only text and numbers");
          this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
      }else{
          $("#lblError").html("");
      }
  });*/
</script>