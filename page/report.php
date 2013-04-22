<?php
	//generate and export document only upon clicking the export button
	if(isset($_POST['export'])) {
		//import PHPExcel file and create dao instance
		require_once("../web/PHPExcel_1.7.8/Classes/PHPExcel.php");
		$dao = new TodoDao();
		$db = $dao->getDb();

		//get user name for document generation
		$array = explode('-', $_SESSION['name']);

		//create phpExcel document, set properties
		$filename = '';
		$phpExcel = new PHPExcel();
		$phpExcel->getProperties()->setCreator($array[0]);
		$phpExcel->getProperties()->setLastModifiedBy($array[0]);
		
		//determine template based on user settings
		if(strcmp($_POST['reportBy'], "byProject") == 0) {
			if(strcmp($_POST['allProjects'],'Yes') == 0){
				$templatePath = '../web/Excel_Templates/Projects_Template.xls';
				$filename = 'multiple-project-report.xls';
			}
			else {
				$templatePath = '../web/Excel_Templates/Project_Template.xls';
				$filename = 'single-project-report.xls';
			}
		}

		if(strcmp($_POST['reportBy'], "byEmployee") == 0) {
			if(strcmp($_POST['allEmployees'],'Yes') == 0) {
				$templatePath = '../web/Excel_Templates/Employees_Template.xls';
				$filename = 'multiple-employee-report.xls';
			}
			else {
				$templatePath = '../web/Excel_Templates/Employee_Template.xls';
				$filename = 'single-employee-report.xls';
			}
		}
		
		//replace main sheet with template sheet
		$template = PHPExcel_IOFactory::load($templatePath);
		$templateSheet = clone $template->getActiveSheet();
		$phpExcel->removeSheetByIndex(0);
		$phpExcel->addExternalSheet($templateSheet);
		$phpExcel->setActiveSheetIndex(0); 
		$sheet = $phpExcel->getActiveSheet();

		//store bordering style for row generation
		$bordering = array(
			'borders' => array(
        			'left' => array(
          				'style' => PHPExcel_Style_Border::BORDER_THIN,
        			),
        			'right' => array(
          				'style' => PHPExcel_Style_Border::BORDER_THIN,
        			),
        			'bottom' => array(
          				'style' => PHPExcel_Style_Border::BORDER_THIN,
        			), 
        			'top' => array(
          				'style' => PHPExcel_Style_Border::BORDER_THIN,
        			), 
      			),
		);

		//retrieving colors for alternation during row generation
		$yellow = $sheet->getStyle('N14')->getFill()->getStartColor()->getRGB();
		$gray = $sheet->getStyle('O14')->getFill()->getStartColor()->getRGB();
	
		//remove colored cell used for setting colors
		$sheet->getStyle('N14:O14')->applyFromArray(
    			array(
        			'fill' => array(
            				'type' => PHPExcel_Style_Fill::FILL_SOLID,
            				'color' => array('rgb' => 'FFFFFF')
   				)
    			)
		);

		//assign colors to arrays containing font styling for row generation
		$fillYellow = array(
              	'fill' => array(
                  		'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  		'color' => array('rgb'=>"$yellow"),
              	),
			'font' => array(
            			'color' => array(
                			'rgb' => '000000'
            			)
			),
		);

		$fillGray = array(
              	'fill' => array(
                  	'type' => PHPExcel_Style_Fill::FILL_SOLID,
                  	'color' => array('rgb'=>"$gray"),
              	),
			'font'    => array(
            			'color' => array(
                			'rgb' => '000000'
            			)
			),
		);		

		//EXPORT REPORTS BY PROJECT
 		if(strcmp($_POST['reportBy'], "byProject") == 0) {
			$sql="SELECT * FROM projects";

			//ALL PROJECTS
			if(strcmp($_POST['allProjects'],'Yes') == 0) {
				$phpExcel->getProperties()->setTitle('All Projects Brief');
				$phpExcel->getProperties()->setSubject("Collective Project Report");
				$phpExcel->getProperties()->setDescription("Primary Projects' Data summary");
				$sql = $sql.' WHERE deleted = 0';
				$result= $db->query($sql) or die('Error: 1' . mysql_error());

				$rowCounter = 8;
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$sheet->insertNewRowBefore($rowCounter,1);
					$sheet->getRowDimension($rowCounter)->setRowHeight(-1);
					$sheet->getStyle("B$rowCounter")->getAlignment()->setWrapText(true);
					$sheet->getStyle("E$rowCounter")->getAlignment()->setWrapText(true);
					$sheet->getStyle("G$rowCounter")->getAlignment()->setWrapText(true);
					$sheet->getStyle("H$rowCounter")->getAlignment()->setWrapText(true);
					$sheet->getStyle("B$rowCounter:H$rowCounter")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

					$sheet->getStyle("B$rowCounter:H$rowCounter")->applyFromArray($bordering, false);
					if($rowCounter % 2 == 0) {
    						$sheet->getStyle("B$rowCounter:H$rowCounter")->applyFromArray($fillYellow);
					}
					else {
    						$sheet->getStyle("B$rowCounter:H$rowCounter")->applyFromArray($fillGray);
					}
					$sheet->setCellValue("B$rowCounter", $row['title']);
					$sheet->setCellValue("C$rowCounter", $row['created_on']);
					$sheet->setCellValue("D$rowCounter", $row['due_on']);
					$sql2 = "SELECT name FROM employee, worksOn WHERE eid = id AND pid = $row[id]";
					$result2 = $db->query($sql2) or die('Error: 2' . mysql_error());
					if($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
						$employees = '';
						do {
							$employees .= $row2['name'].', ';
						}while($row2 = $result2->fetch(PDO::FETCH_ASSOC));
						$employees = substr($employees,0,-1);
						$employees = substr($employees,0,-1);
						$sheet->setCellValue("E$rowCounter", $employees);
					}
					else {
						$sheet->setCellValue("E$rowCounter", 'N/A');
					} 
 					$sheet->setCellValue("F$rowCounter", $row['status']);
					$description = $row['description'];
					if($description) {
						$sheet->setCellValue("G$rowCounter", $description);
					}
					else {
						$sheet->setCellValue("G$rowCounter", 'N/A');
					}
					$comment = $row['comment'];
					if($comment) {
						$sheet->setCellValue("H$rowCounter", $comment);
					}
					else {
						$sheet->setCellValue("H$rowCounter", 'N/A');
					}
					$rowCounter++;
				}
				$rowCounter++;
				$sheet->setCellValue("C$rowCounter", $array[0]);
			}

			//SINGLE PROJECT
			else {
				$sql = $sql." WHERE id = $_POST[project]";
				$result= $db->query($sql) or die('Error: 3' . mysql_error());
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$phpExcel->getProperties()->setTitle("Project Status: ".$row['title']);
				$phpExcel->getProperties()->setSubject("Signle Project Report");
				$phpExcel->getProperties()->setDescription("Primary Project Data for $row[title]");
				$sheet->getRowDimension('6')->setRowHeight(-1);
				$sheet->getStyle('C6')->getAlignment()->setWrapText(true);
				$sheet->setCellValue("C6", $row['title']);
				$sheet->setCellValue("C7", $row['created_on']);
				$sheet->setCellValue("C8", $row['due_on']);
				switch ($row['priority']) {
					case ($row['priority'] == 3): 
						$sheet->setCellValue('C9', 'HIGH');
						break;
					case ($row['priority'] == 2):
						$sheet->setCellValue('C9', 'MEDIUM');
						break;
					default: 
						$sheet->setCellValue('C9', 'LOW');
						break;
				}
				$sheet->setCellValue("C11", $row['status']);

				$description = $row['description'];
				if($description) {
					$sheet->setCellValue("C12", $description);
				}
				else {
					$sheet->setCellValue("C12", 'N/A');
				}
				$sheet->getStyle('C12')->getAlignment()->setWrapText(true);
				$comment = $row['comment'];
				if($comment) {
				$sheet->setCellValue("C13", $comment);
				}
				else {
				$sheet->setCellValue("C13", 'N/A');
				}
				$sheet->getStyle('C13')->getAlignment()->setWrapText(true);

				$sql = "SELECT name FROM employee, worksOn WHERE eid = id AND pid = $_POST[project]";
				$result= $db->query($sql) or die('Error: 4' . mysql_error());
			
				if($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$employees = '';
					do {
						$employees .= $row['name'].', ';
					}while($row = $result->fetch(PDO::FETCH_ASSOC));
					$employees = substr($employees,0,-1);
					$employees = substr($employees,0,-1);
					$sheet->setCellValue('C10', $employees);
				}
				else {
					$sheet->setCellValue('C10', 'N/A');

				}	

				$rowCounter = 17;			
				$sql = "SELECT * FROM task WHERE pid = $_POST[project]";
				$result= $db->query($sql) or die('Error: 5' . mysql_error());
			
		   		if($row = $result->fetch(PDO::FETCH_ASSOC)) {

					do {
						$sheet->insertNewRowBefore($rowCounter,1);
						$sheet->getStyle("B$rowCounter:J$rowCounter")->applyFromArray($bordering, false);
						$sheet->mergeCells("C$rowCounter:D$rowCounter");
						$sheet->mergeCells("F$rowCounter:G$rowCounter");
						$sheet->mergeCells("I$rowCounter:J$rowCounter");
						if($rowCounter % 2 != 0) {
    							$sheet->getStyle("B$rowCounter:J$rowCounter")->applyFromArray($fillYellow);
						}
						else {
    							$sheet->getStyle("B$rowCounter:J$rowCounter")->applyFromArray($fillGray);
						} 
						$sheet->setCellValue("B$rowCounter", $row['title']);
						$sheet->setCellValue("C$rowCounter", $row['start']);
						$sheet->setCellValue("E$rowCounter", $row['end']);
						$interval = floor((strtotime($row['end']) - strtotime($row['start']))/86400);
						$sheet->getStyle("H$rowCounter")->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

						$sql2 = "SELECT name from employee, onTask WHERE id = eid AND tid = $row[tid]";
						$result2 = $db->query($sql2) or die('Error: 6' . mysql_error());
						if($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
							$employees = '';
							do {
								$employees .= $row2['name'].', ';
							}while($row2 = $result2->fetch(PDO::FETCH_ASSOC));
							$employees = substr($employees,0,-1);
							$employees = substr($employees,0,-1);
							$sheet->setCellValue("F$rowCounter", $employees);
						}
						else {
							$sheet->setCellValue("F$rowCounter", 'N/A');

						} 

						$sheet->setCellValue("H$rowCounter", $interval);
						$completed = $row['completedOn'];
						if($completed) {
							$sheet->setCellValue("I$rowCounter", "COMPLETED");
						}
						else {
							$sheet->setCellValue("I$rowCounter", "CURRENT");
						}
						$rowCounter++;
					}while($row = $result->fetch(PDO::FETCH_ASSOC));
					$rowCounter++;
					$sheet->setCellValue("C$rowCounter", $array[0]);
		   		}
		   		else {
					$sheet->removeRow(16);
					$sheet->removeRow(15);
					$sheet->setCellValue('B15', '(No Milestones for this project)');
					$sheet->getStyle('B15')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
					$sheet->setCellValue('C16', $array[0]);
		   		}
			}
		}

		//EXPORT REPORTS BY EMPLOYEE
		if(strcmp($_POST['reportBy'], "byEmployee") == 0) {
			$sql='SELECT * FROM employee';

			//ALL EMPLOYEES
			if(strcmp($_POST['allEmployees'],'Yes') == 0) {
				$phpExcel->getProperties()->setTitle('All Employees Brief');
				$phpExcel->getProperties()->setSubject("Collective Employee Report");
				$phpExcel->getProperties()->setDescription("Primary Employees' Data summary");

				$fillColor = $fillYellow;
				$result= $db->query($sql) or die('Error: ' . mysql_error());
				$rowCounter = 8;
				$startingRow = 8;
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$sheet->insertNewRowBefore($rowCounter,1);
					$sheet->getStyle("B$rowCounter:H$rowCounter")->applyFromArray($bordering, false);
					$sheet->mergeCells("C$rowCounter:D$rowCounter");
					$sheet->mergeCells("E$rowCounter:F$rowCounter");		
					if($fillColor == $fillYellow) {
						$fillColor = $fillGray;
						
					}
					else {
						$fillColor = $fillYellow;
    					}
					$sheet->getStyle("B$rowCounter:H$rowCounter")->applyFromArray($fillColor);

					$sheet->setCellValue("B$rowCounter", $row['name']);
					$sql2 = "SELECT title, pid FROM projects, worksOn WHERE pid = id AND eid = $row[id]";
					$result2 = $db->query($sql2) or die('Error: ' . mysql_error());
					if($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
						do {
							$projectRow = $rowCounter;
							$sheet->setCellValue("C$rowCounter", $row2['title']);
							$sql3 = "SELECT * FROM task WHERE pid = $row2[pid]";
							$result3 = $db->query($sql3) or die('Error: ' . mysql_error());
							if($row3 = $result3->fetch(PDO::FETCH_ASSOC)) {
								do {
									$interval = floor((strtotime($row3['end']) - strtotime($row3['start']))/86400);
									$sheet->getStyle("G$rowCounter")->getNumberFormat()->setFormatCode(
										PHPExcel_Style_NumberFormat::FORMAT_TEXT );
									$sheet->setCellValue("E$rowCounter", $row3['title']);
									$sheet->setCellValue("G$rowCounter", $interval);
									$sheet->setCellValue("H$rowCounter", $row3['end']);
									$sheet->mergeCells("E$rowCounter:F$rowCounter");
									$rowCounter++;
									$sheet->insertNewRowBefore($rowCounter,1);
								}while($row3 = $result3->fetch(PDO::FETCH_ASSOC));
								$sheet->removeRow($rowCounter);
								$rowCounter--;
							}
							else {
								$sheet->setCellValue("E$rowCounter", 'N/A');
								$sheet->setCellValue("G$rowCounter", 'N\A');
								$sheet->setCellValue("H$rowCounter", 'N\A');
								$sheet->mergeCells("E$rowCounter:F$rowCounter");
							} 
							$sheet->mergeCells("C$projectRow:D$rowCounter");
							$sheet->getStyle("C$projectRow")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
							$rowCounter++;
							$sheet->insertNewRowBefore($rowCounter,1);
						}while($row2 = $result2->fetch(PDO::FETCH_ASSOC));
						$sheet->removeRow($rowCounter);
						$rowCounter--;
					}
					else {
						$sheet->setCellValue("C$rowCounter", 'N\A');
						$sheet->setCellValue("E$rowCounter", 'N\A');
						$sheet->setCellValue("G$rowCounter", 'N\A');
						$sheet->setCellValue("H$rowCounter", 'N\A');
					}	
					$sheet->mergeCells("B$startingRow:B$rowCounter");
					$sheet->getStyle("B$startingRow")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
					$rowCounter++;
					$startingRow = $rowCounter;
		
				}
				$rowCounter += 2;
				$sheet->setCellValue("C$rowCounter", $array[0]);
			}

			//SINGLE EMPLOYEE
			else {
				$sql .= " WHERE id = $_POST[employee]";
				$result= $db->query($sql) or die('Error: ' . mysql_error());
				$row = $result->fetch(PDO::FETCH_ASSOC);
				$phpExcel->getProperties()->setTitle("Employee Status: ".$row['name']);
				$phpExcel->getProperties()->setSubject("Individual Employee Report");
				$phpExcel->getProperties()->setDescription("Primary Employee Data for $row[name]");
				$sheet->setCellValue('F6', $row['name']);
				$sql = "SELECT title, priority, due_on, pid FROM projects, worksOn WHERE id = pid AND eid = $_POST[employee]";
				$result= $db->query($sql) or die('Error: 1' . mysql_error());
				$rowCounter = 10;
				while($row = $result->fetch(PDO::FETCH_ASSOC)) {
					$startingRow = $rowCounter;
					$sheet->insertNewRowBefore($rowCounter,1);
					$sheet->getStyle("B$rowCounter:I$rowCounter")->applyFromArray($bordering, false);
					if($fillColor == $fillYellow) {
						$fillColor = $fillGray;
						
					}
					else {
						$fillColor = $fillYellow;
    					}
					$sheet->getStyle("B$rowCounter:I$rowCounter")->applyFromArray($fillColor);
					$sheet->setCellValue("B$rowCounter", $row['title']);
					switch ($row['priority']) {
						case ($row['priority'] == 3): 
							$sheet->setCellValue("C$rowCounter", 'HIGH');
							break;
						case ($row['priority'] == 2):
							$sheet->setCellValue("C$rowCounter", 'MEDIUM');
							break;
						default: 
							$sheet->setCellValue("C$rowCounter", 'LOW');
							break;
					}
					$sheet->setCellValue("D$rowCounter", $row['due_on']);
					$sql2 = "SELECT * FROM task WHERE pid = $row[pid]";
					$result2 = $db->query($sql2) or die('Error: 2' . mysql_error());
					if($row2 = $result2->fetch(PDO::FETCH_ASSOC)) {
						do {
							$sheet->setCellValue("E$rowCounter", $row2['title']);
							$sheet->setCellValue("F$rowCounter", $row2['start']);
							$sheet->setCellValue("G$rowCounter", $row2['end']);
							$interval = floor((strtotime($row3['end']) - strtotime($row3['start']))/86400);
							$sheet->getStyle("H$rowCounter")->getNumberFormat()->setFormatCode(
									PHPExcel_Style_NumberFormat::FORMAT_TEXT );
							$sheet->setCellValue("H$rowCounter", $interval);
							$completed = $row['completedOn'];
							if($completed) {
								$sheet->setCellValue("I$rowCounter", "COMPLETED");
							}
							else {
								$sheet->setCellValue("I$rowCounter", "CURRENT");
							}
							$rowCounter++;
							$sheet->insertNewRowBefore($rowCounter,1);
						}while($row2 = $result2->fetch(PDO::FETCH_ASSOC));
						$sheet->removeRow($rowCounter);
						$rowCounter--;
						$sheet->mergeCells("B$startingRow:B$rowCounter");
						$sheet->mergeCells("C$startingRow:C$rowCounter");
						$sheet->mergeCells("D$startingRow:D$rowCounter");
						$sheet->getStyle("B$startingRow")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$sheet->getStyle("C$startingRow")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
						$sheet->getStyle("D$startingRow")->getAlignment()->setVertical(
							PHPExcel_Style_Alignment::VERTICAL_CENTER);				
					}
					else {
					       $sheet->setCellValue("E$rowCounter", 'N\A');
						$sheet->setCellValue("F$rowCounter", 'N\A');
						$sheet->setCellValue("G$rowCounter", 'N\A');
						$sheet->setCellValue("H$rowCounter", 'N\A');
						$sheet->setCellValue("I$rowCounter", 'N\A');
					}
					$rowCounter++;		
				}
				$rowCounter++;
				$sheet->setCellValue("C$rowCounter", $array[0]);
	
			}
		}


		//Output the generated excel file so that the user can save or open the file.
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$filename");
		header("Cache-Control: max-age=0");
 
		$objWriter = PHPExcel_IOFactory::createWriter($phpExcel, "Excel5");
		$objWriter->save("php://output");
		$dao->__destruct();
		exit;

	}
?>
