<?php

//insert.php

include('database_connection.php');

$form_data = json_decode(file_get_contents("php://input"));

$error = '';
$message = '';
$validation_error = '';
$name = '';
$charge = '';

if($form_data->action == 'fetch_single_data')
{
	$query = "SELECT * FROM user WHERE id='".$form_data->id."'";
	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	foreach($result as $row)
	{
		$output['name'] = $row['name'];
		$output['charge'] = $row['charge'];
	}
}
elseif($form_data->action == "Delete")
{
	$query = "
	DELETE FROM user WHERE id='".$form_data->id."'
	";
	$statement = $connect->prepare($query);
	if($statement->execute())
	{
		$output['message'] = 'Data Deleted';
	}
}
else
{
	if(empty($form_data->name))
	{
		$error[] = 'First Name is Required';
	}
	else
	{
		$name = $form_data->name;
	}

	if(empty($form_data->charge))
	{
		$error[] = 'Last Name is Required';
	}
	else
	{
		$charge = $form_data->charge;
	}

	if(empty($error))
	{
		if($form_data->action == 'Insert')
		{
			$data = array(
				':name'		=>	$name,
				':charge'		=>	$charge
			);
			$query = "
			INSERT INTO user 
				(name, charge) VALUES 
				(:name, :charge)
			";
			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Inserted';
			}
		}
		if($form_data->action == 'Edit')
		{
			$data = array(
				':name'	=>	$name,
				':charge'	=>	$charge,
				':id'			=>	$form_data->id
			);
			$query = "
			UPDATE user 
			SET name = :name, charge = :charge 
			WHERE id = :id
			";

			$statement = $connect->prepare($query);
			if($statement->execute($data))
			{
				$message = 'Data Edited';
			}
		}
	}
	else
	{
		$validation_error = implode(", ", $error);
	}

	$output = array(
		'error'		=>	$validation_error,
		'message'	=>	$message
	);

}



echo json_encode($output);

?>