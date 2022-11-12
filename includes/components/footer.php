<?php
?>
<footer>
    <div class="footer-top">
        <h5><span>Random Fun Fact:</span>
        <?php
        
        $query = 'SELECT fact FROM funfacts ORDER BY RAND() LIMIT 1';
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        $stmt->closeCursor();

        if ($stmt->rowCount() > 0) {
            echo $result['fact'];
        } else {
            echo "No funfact found";
        }   
        ?>
        </h5>
    </div>
    <pre>
        
__/\\\________________________________________________        
 _\/\\\________________________________________________       
  _\/\\\___________________________________________/\\\_      
   _\/\\\_________________/\\\\\\\\___/\\\____/\\\_\///__     
    _\/\\\_______________/\\\/////\\\_\//\\\__/\\\___/\\\_    
     _\/\\\______________/\\\\\\\\\\\___\//\\\/\\\___\/\\\_   
      _\/\\\_____________\//\\///////_____\//\\\\\____\/\\\_  
       _\/\\\\\\\\\\\\\\\__\//\\\\\\\\\\____\//\\\_____\/\\\_ 
        _\///////////////____\//////////______\///______\///__
<a href="https://www.instagram.com/levi_slavi/" target="_blank">Instagram</a> <a href="https://www.behance.net/leviv" target="_blank">Behance</a> <a href="https://github.com/LeviFX" target="_blank">Github</a> <a href="https://www.linkedin.com/in/levi-vogel-37770320b/" target="_blank">LinkedIn</a>
    </pre>
</footer>