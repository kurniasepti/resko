<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('Commonfunction','','fn');
				
		if(!isset($this->session->userdata['name']))		
			redirect("login","refresh");
		
		
	}
	/*	
		====================================================== Variable Declaration =========================================================
	*/
	
	var $mainTable="tb_user";
	var $mainPk="id_user";
	var $viewLink="User";
	var $breadcrumbTitle="Daftar User";
	var $viewPage="Admviewpage3";
	var $addPage="Admaddpage";
	
	//query
	var $ordQuery=" ORDER BY id_user"; //pengurutan berdasarkan kolomnya//
	var $tableQuery="
						tb_user
						";
	var $fieldQuery="id_user,
					id_pgw,
					nama_user,
					username_user,
					password_user,
					hak_akses,
					jenis_kel,
					telp_pgw,
					alamat,
					foto_pgw"; //leave blank to show all field atau kolom
						
	var $primaryKey="id";
	var $updateKey="id_user";
	
	//auto generate id
	var $defaultId="U01";
	var $prefix="U";
	var $suffix="01";	
	
	//view
	var $viewFormTitle="Daftar User";
	var $viewFormTableHeader=array(
									"Id User",
									"Nama User",
									"Id_pgw",
									"Username",
									"Password User",
									"Hak Akses",
									"Jenis Kelamin",
									"Telp Pegawai",
									"Alamat",
									"Foto Pegawai");
	
	//save
	var $saveFormTitle="Tambah User";
	var $saveFormTableHeader=array(
									"Id User",
									"Nama User",
									"Id_pgw",
									"Username",
									"Password User",
									"Hak Akses",
									"Jenis Kelamin",
									"Telp Pegawai",
									"Alamat",
									"Foto Pegawai");
	
	//update
	var $editFormTitle="Edit Data User";
	
	/*	
		========================================================== General Function =========================================================
	*/
	
	public function index()
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
			
		
		//init view
		
		
		$renderTemp=$this->Mmain->qRead($this->tableQuery.$this->ordQuery,$this->fieldQuery,"");
		foreach($renderTemp->result() as $row)
		{
			$row->foto_pgw="<img src='".base_url()."/assets/admin/img/".$row->foto_pgw."' height='100px' width='auto' class='center-block'>";
		}
		$output['render']=$renderTemp;
		//init view
		$output['pageTitle']=$this->viewFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/add";
		$output['deleteLink']=$this->viewLink."/delete";
		$output['primaryKey']=$this->primaryKey;
		$output['tableHeader']=$this->viewFormTableHeader;
		
		//render view
		$this->fn->getheader();
		$this->load->view($this->viewPage,$output);
		$this->fn->getfooter();
	}
	

	
	public function add($isEdit="")
	{
		//init modal
		$this->load->database();
		$this->load->model('Mmain');
		
		
		//init view
		$output['pageTitle']=$this->saveFormTitle;
		$output['breadcrumbTitle']=$this->breadcrumbTitle;
		$output['breadcrumbLink']=$this->viewLink;
		$output['saveLink']=$this->viewLink."/save";
		$output['tableHeader']=$this->saveFormTableHeader;
		$output['formLabel']=$this->saveFormTableHeader;
		
		$imgTemp="";
		$codeTemp="";
		if(!empty($isEdit))
		{
			
			$output['pageTitle']=$this->editFormTitle;
			$output['saveLink']=$this->viewLink."/update";
			$pid=$isEdit;
			$render=$this->Mmain->qRead($this->tableQuery,$this->fieldQuery,$this->mainPk."  = '".$pid."'");
			foreach($render->result() as $row)
			{
				foreach($row as $col)
				{
					$txtVal[]= $col;
				}
			}
			
				
				//$cboloc=$this->fn->createCbofromDb("tb_loc","id_loc as id,nm_loc as nm","",$txtVal[6]);
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),$txtVal[8]);
					
				$imgTemp="<h5><i>Click browse to change image</i></h5>
							<img src='".base_url()."/assets/admin/img/avatar/thumb/".$txtVal[3]."' height='200px' width='auto' >
							<input type='hidden' name='txtimg' value='".$txtVal[3]."'>";
		}
		else //untuk add
		{	
				for($i=0;$i<count($this->saveFormTableHeader);$i++)
				{
					$txtVal[]="";
				}	
				
				//generate id
				$newId=$this->Mmain->autoId($this->mainTable,$this->mainPk,$this->prefix,$this->defaultId,$this->suffix);	
				$txtVal[0]=$newId;
				
			
				//$cbosex=$this->fn->createCbo(array(1,0),array("Male","Female"),"");
				//$cbostat=$this->fn->createCbo(array(1,0),array("Active","Inactive"),"");
		}

				$cboakses=$this->fn->createCbo(array("Perawat","Bidan"),array("Perawat","Bidan"),$txtVal[5]);
				$cbojeniskel=$this->fn->createCbo(array("Perempuan","Laki-laki"),array("Perempuan","Laki-laki"),$txtVal[6]);
		$output['formTxt']=array(
								$codeTemp."<input type='text' class='form-control' id='txtid0' name=txt[] value='".$txtVal[0]."' readonly>",
								"<input type='text' class='form-control' id='txtid1' name=txt[] value='".$txtVal[1]."' required>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[2]."' required>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[3]."' required>",
								"<input type='password' class='form-control' id='txtpass' name=txt[] value='".$txtVal[4]."' required>",
								$cboakses,
								$cbojeniskel,
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[7]."' required>",
								"<input type='text' class='form-control' id='txtid2' name=txt[] value='".$txtVal[8]."' required>",
								$imgTemp."<input type='file' class='form-control fileupload' id='txtid23' name=txtfl >"
								);
		
		
		//load view
		$this->fn->getheader();
		$this->load->view($this->addPage,$output);
		$this->fn->getfooter();
	}	
	
	public function save()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		
		$avauser="";
		if(!empty($_FILES['txtfl']['name']))
		{
			$flName=$_FILES['txtfl']['name'];
			$flTmp=$_FILES['txtfl']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/".$flName);
			$avauser=$flName;
		}
		else
		{
			$avauser="def.jpg";
		}
		$savValTemp[]=$avauser;
		
		$savValTemp[4]=md5($savValTemp[4]);
		//echo implode("<br>",$savEmp);
		$this->Mmain->qIns($this->mainTable,$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//delete record
	public function delete($valId)
	{		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
		$this->Mmain->qDel($this->mainTable,$this->mainPk,$valId);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
	//update record
	public function update()
	{
		//retrieve values
		$savValTemp=$this->input->post('txt');
		
		//save to database
		$this->load->database();
		$this->load->model('Mmain');
	/*	$avauser="";
		if(!empty($_FILES['txtfl']['name']))
		{
			$flName=$_FILES['txtfl']['name'];
			$flTmp=$_FILES['txtfl']['tmp_name'];
			move_uploaded_file($flTmp,"assets/admin/img/avatar/thumb/".$flName);
			$avauser=$flName;
		}
		else
		{
			$avauser=$this->input->post('txtimg');
		}
		
		$savValTemp[]=$avauser;
*/
		$savValTemp[3]=md5($savValTemp[3]);
		$this->Mmain->qUpd($this->mainTable,$this->mainPk,$savValTemp[0],$savValTemp);
		
		//redirect to form
		redirect($this->viewLink,'refresh');		
	}
	
}

?>