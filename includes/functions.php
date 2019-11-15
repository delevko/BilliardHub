<?php

function dump($variable)
{
	require(HOME_DIR."/templates/dump.php");
}


function apology($error, $message="Повідомте, будь ласка, адміністратора про помилку")
{
	render("apology.php", ["title" => "Помилка", "message" => $message, "errorType" => $error]);
}


function render($file, $values=[])
{
	if(file_exists(HOME_DIR."/templates/$file")) 
	{
		extract($values);

		require(HOME_DIR."/templates/header.php");
		
		require(HOME_DIR."/templates/$file");
		
		require(HOME_DIR."/templates/footer.php");
	}
	else
	{
		$msg = "Файл ".$file." не існує";
		apology(OTHER_ERROR, $msg);
		exit;
	}
}


function adminApology($error, $message="Повідомте, будь ласка, адміністратора про помилку")
{
	render("apology.php", ["title" => "Помилка", "message" => $message, "errorType" => $error]);
}


function adminRender($file, $values=[])
{
	if(file_exists(HOME_DIR."/templates/admin/$file")) 
	{
		extract($values);

		require(HOME_DIR."/templates/admin/header.php");
		
		require(HOME_DIR."/templates/admin/$file");
		
		require(HOME_DIR."/templates/admin/footer.php");
	}
	else
	{
		$msg = "Файл ".$file." не існує";
		adminApology(OTHER_ERROR, $msg);
		exit;
	}
}

function navButtonsRender()
{
	navButtonsHeader();

	if( isset($_SESSION["id"]) )
	{
		if( $_SESSION["id"]["type"] == "admin" )
		{
			adminButton();
			logoutButton();
		}
		else if( $_SESSION["id"]["type"] == "regular" )
		{
			playerButton($_SESSION["id"]["login"]);
			logoutButton();
		}
	}
	else
	{
		loginButton();
		registerButton();
	}

	navButtonsFooter();
}

function navButtonsHeader() { ?>
	<div class="header_buttons">
<?php }
function navButtonsFooter() { ?>
	</div>
<?php }

function adminButton() { ?>
        <a href="<?=PATH_H?>admin/" class="login">
            <i class="fas fa-user-shield"></i>
            <span>&nbsp;Адмін панель</span>
        </a>
<?php }
function playerButton($player) { ?>
        <a href="<?=PATH_H?>player/settings.php" class="login">
            <i class="fas fa-user"></i>
            <span>&nbsp;<?=$player.""?></span>
        </a>
<?php }

function loginButton() { ?>
        <a href="<?=PATH_H?>login.php" class="login">
            <i class="fas fa-sign-in-alt"></i>
            <span>&nbsp;Увійти</span>
        </a>
<?php }
function logoutButton() { ?>
        <a href="<?=PATH_H?>logout.php" class="login">
            <i class="fas fa-sign-out-alt"></i>
            <span>&nbsp;Вийти</span>
        </a>
<?php }
function registerButton() { ?>
        <a href="<?=PATH_H?>register.php" class="login">
            <i class="fas fa-user"></i>
            <span>&nbsp;Зареєструватись</span>
        </a>
<?php }



function firstGreaterPowerOf2($n)
{
	$N = 2;
	while($N < $n)
	{
		$N = $N * 2;
	}
	return $N;
}

function getSeedingArrayMy($currRound, $standart, $N)
{
    if( $currRound > 1 ){
		if( $standart % 2 == 0 ){
            $arr = array_merge(
                getSeedingArrayMy($currRound-1, $N/POW(2,$currRound-1)-$standart+1, $N), 
                getSeedingArrayMy($currRound-1, $standart, $N) 
            );
        }
        else{
            $arr = array_merge( 
                getSeedingArrayMy($currRound-1, $standart, $N), 
                getSeedingArrayMy($currRound-1, $N/POW(2,$currRound-1)-$standart+1, $N) 
            );
        }
    }
    else if( $currRound = 1 ) {
        return array($standart, $N-$standart+1);
    }
    return $arr;
}


function getSeedingArray( $currRound, $standart, $N )
{
	if( $currRound > 1 )
	{
		if( $standart % 2 == 0 ){
            $arr = array_merge(
				getSeedingArray($currRound-1, $N/POW(2,$currRound-1)-$standart+1, $N), 
				getSeedingArray($currRound-1, $standart, $N) 
			);
        }
		else{
            $arr = array_merge( 
				getSeedingArray($currRound-1, $standart, $N), 
				getSeedingArray($currRound-1, $N/POW(2,$currRound-1)-$standart+1, $N) 
			);
    	}
	}
    else if( $currRound = 1 )
    {
        if( $standart % 2 == 0 )
            return array($N-$standart+1, $standart);
        else
            return array($standart, $N-$standart+1);
	}

    return $arr;
}


function getTypes($params)
{
	$types = "";
	for($i = 0; $i<count($params); $i++)
	{
		if(gettype($params[$i]) == "string")
			$types .= 's';
		else if(gettype($params[$i]) == "integer")
			$types .= 'i';
		else if(gettype($params[$i]) == "double")
			$types .= 'd';
	}
	
	$a_params = array();
	$a_params[] = & $types;
	for($i=0; $i<count($params); $i++)
	{
		$a_params[] = & $params[$i];
	}
	return $a_params;
}

function JSquery()
{
	$query = func_get_arg(0);
	$params = array_slice(func_get_args(), 1);

	$mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
	if($mysqli->connect_errno)
		return false;
	
	if( !empty($params) )
	{
		$a_params = getTypes($params);

		$stmt = $mysqli->prepare($query);
		if($stmt === false)
			return false;

		if(!call_user_func_array(array($stmt,'bind_param'),$a_params))
			return false;
		if( !$stmt->execute() )
			return false;
	}
	else
	{
		if(!$mysqli->query($query))
			return false;
	}

	$mysqli->close();
	return true;
}


function query()
{
	$query = func_get_arg(0);
	$params = array_slice(func_get_args(), 1);

	$mysqli = new mysqli(SERVER, USERNAME, PASSWORD, DATABASE);
	if($mysqli->connect_errno)
	{
		adminApology(OTHER_ERROR, "Failed to connect to MySQL: (".$mysqli->connect_errno.") ".$mysqli->connect_error);
		exit;
	}
	
	if( !empty($params) )
	{

		$a_params = getTypes($params);

		$stmt = $mysqli->prepare($query);
		if($stmt === false)
		{
			adminApology(OTHER_ERROR, "1Query error: ".$query);
			exit;
		}

		if(!call_user_func_array(array($stmt,'bind_param'),$a_params))
		{
			adminApology(OTHER_ERROR, "2Query error: ".$query);
			exit;
		}
		if( !$stmt->execute() )
		{
			adminApology(OTHER_ERROR, "3Query error: ".$query." ".$stmt->error);
			exit;
		}

		if(strcasecmp(substr($query, 0, 6), "select") !== 0)
		{
			return;
		}
		$result = $stmt->get_result();
	}
	else
	{
		if(strcasecmp(substr($query, 0, 6), "select") !== 0)
		{
			if(!$mysqli->query($query))
			{
				adminApology(OTHER_ERROR, "4Query error ".$query);
				exit;
			}
			return;
		}

		$result = $mysqli->query($query);
	}

	if($result === false)
	{
		adminApology(OTHER_ERROR, "5Query error: $query $params");
		exit;
	}
	$mysqli->close();
	return $result->fetch_all();
}



function nonEmpty()
{
	foreach(func_get_args() as $arg)
	{
		if(!isset($arg) || $arg === "")
			return false;
	}
	return true;
}

function exists($table, $id)
{
	$query = "SELECT 1 FROM $table WHERE id=? LIMIT 1";
	if(count(query($query, $id)) !== 1)
	{
		return false;
	}
	else
	{
		return true;
	}
}
	
function mailCheck($email)
{
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false )
	{
		return false;
	}
	else
	{
		return $email;
	}
}

function loginAvailable($login)
{
	$data = query("SELECT 1 from _user WHERE login=? LIMIT 1", $login);
	
	if(count($data) > 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}



function castTournamentHeader($header)
{
	if($header == "Live")
		return "Наживо";
	else if($header == "Registration")
		return "Триває Реєстрація";
	else if($header == "Announced")
		return "Оголошені";
	else if($header == "Standby")
		return "Реєстрацію завершено";
	else if($header == "Finished")
		return "Завершені";
}

function castMatchHeader($hdr)
{
    if($hdr == "Group")
        return "Група ";

    if($hdr == "K/O")
        return "Knockout - раунд ";

    if($hdr == "UP")
        return "Верхня сітка - раунд ";

    if($hdr == "LOW")
        return "Нижня сітка - раунд ";
}

function castBreakRound($hdr)
{
    if($hdr == "Group")
        return "Група ";

    if($hdr == "K/O")
        return "Knockout ";

    if($hdr == "UP")
        return "Верхня сітка ";

    if($hdr == "LOW")
        return "Нижня сітка ";
}

function castBreakHeader($type, $i, $R, $seeded_R)
{
        if($type == "K/O" && $i >= $seeded_R)
                return castKnockout($i, $R);
        else
                return castBreakRound($type).$i;
}

function castHeader($type, $i, $R, $seeded_R)
{
        if($type == "K/O" && $i >= $seeded_R)
                return castKnockout($i, $R);
        else
                return castMatchHeader($type).$i;
}


function castKnockout($i, $KO_R)
{
    if($i == $KO_R)
        return "Фінал";
    else
        return "1/".pow(2,$KO_R-$i)." Фіналу";
}

?>

