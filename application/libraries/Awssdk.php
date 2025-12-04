<?php

defined('BASEPATH') OR exit('No direct script access allowed');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception as S3;

class Awssdk
{
    protected $CI;
    public $s3;

    public function __construct()
    {      
       
        $config['aws_region'] = 'ap-south-1';
        $credentials = [
            'key'    => $config['aws_access_key'],
            'secret' => $config['aws_secret_key'],
        ];

        $this->s3 = new S3Client([
            'version'     => 'latest',
            'region'      => $config['aws_region'],
           // 'credentials' => $credentials,
        ]);        
       
    }

    public function uploadFile($bucket_name, $key_name, $file_path)
    {
        try{
            $resposne = $this->s3->putObject(array(
                'Bucket' => $bucket_name,
                'Key'    => $key_name,
                'SourceFile' => $file_path,
            ));
            return $resposne;
        }catch(Exception $e){
            
			echo $e->getMessage();
            return '';
        }
    }

    public function uploadFileContent($bucket_name, $key_name, $file_content)
    {
        try{
            $resposne = $this->s3->putObject(array(
                'Bucket' => $bucket_name,
                'Key'    => $key_name,
                'Body' => $file_content
                
            ));

            return $resposne;
        }catch(Exception $e){
            
            echo $e->getMessage();
            return '';
        }
    }

    public function getFile($bucket_name, $key_name){
        try{
            $file = $this->s3->getObject([
                'Bucket' => $bucket_name,
                'Key' => $key_name,
            ]);
            return $file;
        }catch(Exception $e){
            
			return null;
        }
    }
    public function isFileExist($bucket_name, $key_name){
        return $this->s3->doesObjectExist($bucket_name, $key_name);
    }

    public function deleteFile($bucket_name, $key_name){
        $isFileExist = $this->isFileExist($bucket_name, $key_name);   
        try{
        // if ($isFileExist) {
            $delete =  $this->s3->deleteObject([
                'Bucket' => $bucket_name,
                'Key' => $key_name
            ]);
            return $delete;
        // }
        }catch(Exception $x){
            var_dump($x);
        }
    }

    public function getImageData($key_name){
        try{
            
            $bucket_name = 'erp-asset';
            $result = $this->getFile($bucket_name, $key_name);
            $ext_arr = explode('.', $key_name);
            $imageData = base64_encode($result['Body']);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $imageMimeType = $finfo->buffer($result['Body']);
            $dataURI = 'data:' . $imageMimeType . ';base64,' . $imageData;
            return $dataURI;
        }catch(Exception $e){
            ////echo $e->getMessage();die();
            return '';
        }

    }


    public function RenameFIles($directory){
        
        $Ignore = array(".","..","Thumbs.db");
        //$OriginalFileRoot = str_replace("/", "", FCPATH)."\\"."student_document";
        //$OriginalFileRoot = "D:\Sachin\student_document~\student_document";
        $OriginalFileRoot = "D:\sijoull_docs\student_document_old";
        $OriginalFiles = scandir($OriginalFileRoot);
        $DestinationRoot = "D:\sijoull_docs\\final\student_document";
        # Check to see if "backups" exists
        if(!is_dir($DestinationRoot)){
            mkdir($DestinationRoot,0777,true);
        }
        
        //var_dump($OriginalFiles);
        
        foreach($OriginalFiles as $OriginalFile){
            if(!in_array($OriginalFile,$Ignore)){
                try{
                $files_name = explode('-', $OriginalFile);
                $student_id = $files_name[0];
                
                    if(!empty($student_id)){
                       $year = getStudentYear($student_id);
                        if($year){
                            $FileExt = pathinfo($OriginalFileRoot."\\".$OriginalFile, PATHINFO_EXTENSION); // Get the file extension
                            $Filename = basename($OriginalFile, ".".$FileExt); // Get the filename
                            $DestinationFile = $DestinationRoot. "\\". $year."\\".$Filename.".".$FileExt; // Create the destination filename 
                            
                            $temp_name = $OriginalFileRoot."\\".$OriginalFile;
                            $result = copy($OriginalFileRoot."\\".$OriginalFile, $DestinationFile); // rename the 
                            if($result){
                                echo "successfully copied file - ".$OriginalFile."<br/>";
                            }else{
                                echo "failed for file copy - ".$OriginalFile."<br/>";
                            }
                            //var_dump($result);die();
                        }else{
                            echo "failed for ".$OriginalFile. "<br/>";
                        }
                    }
                }catch(Exception $e){
                    echo $temp_name."<br/>";
                }
                
            }
        }
    }

    public function getAllProductionFiles()
    {
        $OriginalFileRoot = '/var/www/html/suproject/project/erp/uploads/student_document/';
		$OriginalFiles = scandir($OriginalFileRoot);
		$all_files = implode(",", $OriginalFiles);
        var_dump($all_files);
    }
    
	public function getsignedurl($key){
		$expires = '+1 hour';
		$bucketName='erp-asset';
		$command = $this->s3->getCommand('GetObject', [
			'Bucket' => $bucketName,
			'Key'    => $key,
		]);
		$request = $this->s3->createPresignedRequest($command, $expires);

		$presignedUrl = (string)$request->getUri();

		// Encode the URL
		return $encodedUrl = $presignedUrl;
	}
    
   public function move_failed_files(){
        $file_string = "-001.pdf,-12th.jpg,-1615299049274.jpg,-170101102011_facilityfee_challan_pdf_(1).pdf,-180101051041_BARVE_MANSI_MAKARAND.pdf,-180102011064_degree_certificate_(8).pdf,-3.pdf,-63224176_1521536539718.pdf,-AGRAWAL_LALIT_SANJAY.pdf,-AGRAWAL_SANJAY_LALCHAND.pdf,-AJAY_KAILASHNATH_DUBEY.pdf,-A_LEVEL.jpg,-BAGUL_RAVINDRA_BHASKAR.pdf,-BAVISKAR_VAIBHAV_ANIILKUMAR.pdf,-BHAGYASHRI_RANGNATH_AARADHI.pdf,-BHALERAO_VANDANA_TUKARAM.pdf,-BHUSARE_PRANALI_PRABHAKAR.pdf,-BOBHATE_GRISHMA_YADAV.pdf,-C.pdf,-CHARANSINGH_INGLE.pdf,-CHAUDHARI_VRUSHALI.pdf,-CHAVAN_DATTATRAY_SAMPAT.pdf,-Contact_us.pdf,-DHARMADHIKARI_PANKAJ_MADHUKAR.pdf,-Desert.jpg,-Diploma.jpeg,-Diploma.jpg,-Diploma.pdf,-GADE_SHYAMRAO_APPASAHEB.pdf,-GIRISH_ASHOKRAO_DASHMUKHE.pdf,-GUJAR_SHUBHANGI_SUBHASH.pdf,-Graduation.pdf,-HSC.jpg,-HSC.pdf,-IMG_20230421_0001.pdf,-INGALE_AKASH_SUDHAKAR.pdf,-JADHAV_SACHIN_ZAMBAR.pdf,-KALE_NAYANA_DILIP.pdf,-KALE_PRAVIN_BHARATRAO.pdf,-KATKADE_SANTOSH_DATTATREYA.pdf,-KORADE_MAHESH_VIJAYRAO.pdf,-KSHIRSAGAR_SOPAN_BAPU.pdf,-KULKARNI_MADHURI_SATISH.pdf,-MAHAJAN_DIGAMBAR_PADMAKAR.pdf,-MAHALE_VISHAL_VIJAY.pdf,-MAHARAJ_SUNITA_GANESHRAO.pdf,-MOHIT_DIGHE.pdf,-Marvelous_Martin_Giahn.pdf,-NITIN_KHARCHE.pdf,-NIVEDITA_SHIMBRE.pdf,-O_LEVEL.jpg,-PACHORKAR_PRAVIN_RAGHUNATH.pdf,-PANDAGALE_SANDEEP_BHAUSAHEB.pdf,-PATIL_GIRISH_NARAYAN.pdf,-PATIL_JAYASHRI_JAYESH.pdf,-PATIL_KUNDAN_BABANRAO.pdf,-PATIL_PRAMOD_CHINDHU.pdf,-PATIL_SAMRUDHI_SANTOSH.pdf,-PAWAR_PRIYANKA_PRABHAKAR.pdf,-PAWAR_SMITA_SATISH.pdf,-PHOTO-2021-02-01-17-21-41.jpg,-Post_Graduation.pdf,-Priscilla_Abakah_WAEC.jpg,-RADHA_SAKHARAM_SAVANKAR.pdf,-RAMAKANT_CHOUDHARI.pdf,-RANDHAVAN_BHAGWAT_MANOHAR.pdf,-RECEIPT.PDF,-SALUNKHE_ASHWINI_SAMPATRAO.pdf,-SANDEEP_KHACHANE.pdf,-SHAH_PRACHI_NAVINCHANDARA.pdf,-SHINDE_PUSHKAR_PRATAP.pdf,-SHIRSATH_PANKAJ_SURESH.pdf,-SHRADDHA_NAMDEORAO_ZANJAT.pdf,-SHUKLA_SANJEEV_ANIL.pdf,-SID6768_-_Albert_Gahadza_-_Zimbabwe_-_B_Tech(Electrical_Engineering).pdf,-SID6768_-_SU_RECEIPT.pdf,-SOMVANSHI_SUVARNA_VIJAYKUMAR.pdf,-SSC.jpg,-SSC.pdf,-SURADKAR_SWATI_BHASKARRAO.pdf,-SUSHMITA_MAHAHAN.pdf,-TC.pdf,-TOPE_MEGHA_BHIMASHANKAR.pdf,-TUPE_JAYDEEP_GAUTAM.pdf,-USHIR_KETAN_EKNATH.pdf,-Untitled_Document.pdf,-VISHAKHA_TOMAR.pdf,-VISPUTE_DHANASHREE_SHAMKANT.pdf,-WARHADE_SMITA_NANASAHEB.pdf,-YEOLE_SANDIP_SHANKAR.pdf,-YM.pdf,-eng-img_(4).jpg,-eng-img_(5).jpg,-eng-img_(6).jpg,-scan0013.pdf,-scan0014.pdf,-scan0015.pdf,-scan_and_download.jpg,.,..,1421-PDF.pdf,14976-Image.jpg,15471-PDF.pdf,17964-GRT.pdf,18037-hsc_x.pdf,18055-17.pdf,18081-HSC_compressed(26).pdf,18221-48.pdf,18221-Diploma_Certificate.pdf,18223-1.pdf,18223-BE_I__II_SEM.pdf,18223-BE_I__II_SEM_compressed(1).pdf,18223-BTECH_I__II_SEM.pdf,18223-shirsath.pdf,18285-scan0001.pdf,18285-scan0003.pdf,18292-IMG_20230925_0001.jpg,18293-lc.pdf,18293-ssc.pdf,18315-scan0001.pdf,18315-scan0002.pdf,18326-10th.pdf,18326-IMG_20231004_0001.jpg,18326-TC.pdf,18329-scan0001.jpg,18329-scan0001.pdf,18329-scan0003.pdf,18332-scan0001.jpg,18332-scan0001.pdf,18332-scan0002.pdf,18342-scan0001.pdf,18342-scan0002.jpg,18342-scan0002.pdf,18365-10th.pdf,18365-MIG.pdf,18365-TC.pdf,18369-LC.pdf,18369-SSC.pdf,18400-GRT_compressed(39).pdf,18439-IMG_20230923_0001.pdf,18475-GRT_compressed(45).pdf,18475-PASSING.pdf,18493-TC.pdf,18535-VALIDITY.pdf,18544-scan0001.jpg,18544-scan0002.pdf,18544-scan0003.pdf,18570-01.pdf,18570-ssc02.pdf,18602-LC.pdf,18602-ssc.pdf,18644-10th.pdf,18644-12th.pdf,18644-TC.pdf,18664-SSC_X.pdf,18664-TC.pdf,18711-Image.jpg,18815-SSC.pdf,18890-2.pdf,18939-LC.pdf,18939-SSC.pdf,18981-10.pdf,18984-LC.pdf,18984-SSC.pdf,19068-scan0001.jpg,19068-scan0002.pdf,19068-scan0003.pdf,19127-1.pdf,19127-SSC.pdf,19135-DIP.pdf,19250-lc.pdf,19261-10th.pdf,19261-IMG_20231004_0003.jpg,19261-TC.pdf,19288-LC.pdf,19296-GRT.pdf,19297-10th.pdf,19297-MIG.pdf,19297-TC.pdf,19301-LC.pdf,19301-SSC.pdf,19378-10th.pdf,19378-TC.pdf,19380-10th.pdf,19380-IMG_20231004_0001.jpg,19380-TC.pdf,19382-10th.pdf,19382-MIG.pdf,19382-TC.pdf,19434-31.pdf,19435-7.pdf,19505-10th.pdf,19505-IMG_20231004_0001.jpg,19505-TC.pdf,19543-27.pdf,19603-10th.pdf,19603-MIG.pdf,19603-TC.pdf,19710-lc.pdf,19710-ssc.pdf,19737-scan0001.jpg,19737-scan0001.pdf,19737-scan0002.pdf,19737-scan0004.pdf,19765-10th.pdf,19765-MIG.pdf,19765-TC.pdf,19774-scan0002.pdf,19774-scan0003.pdf,19777-HSC.pdf,19777-LC.pdf,19777-SSC.pdf,19801-scan0005.jpg,19801-scan0008.pdf,19801-scan0009.pdf,19834-LC.pdf,19834-SSC.pdf,19839-scan0001.pdf,19839-scan0002.pdf,19850-ambar.pdf,19850-suman_gupta.pdf,19876-LC.pdf,19876-SSC.pdf,19880-IMG_20230930_0001_compressed(25).pdf,19907-25.pdf,19907-V.pdf,19914-10th.pdf,19914-IMG_20231005_0002.jpg,19929-HSC_X.pdf,19934-10th.pdf,19934-12th.pdf,19934-IMG_20231005_0001.jpg,19943-10th.pdf,19943-DIP.pdf,19943-IMG_20231005_0001.jpg,19994-HSC_X.pdf,20012-GRT.pdf,20015-LC.pdf,20015-SSC.pdf,20056-Z.pdf,20056-wankhede.pdf,20083-LC.pdf,20083-SSC.pdf,20122-2.pdf,20137-11.pdf,20144-DIP_compressed(40).pdf,20144-VALIDITY.pdf,20146-LC.pdf,20146-SSC.pdf,20183-10th.pdf,20183-12th.pdf,20183-IMG_20231006_0001.jpg,20183-TC.pdf,20198-LC.pdf,20198-SSC.pdf,20228-XZX.pdf,20255-10th.pdf,20255-MIG.pdf,20255-TC.pdf,20300-LC.pdf,20300-PHOTO.jpg,20300-SSC.pdf,20390-HSC.pdf,20390-LC.pdf,20390-SSC.pdf,20418-17.pdf,20432-scan0001.pdf,20448-GRT.pdf,20448-Image.jpg,20453-LC.pdf,20453-SSC.pdf,20462-lc.pdf,20462-ssc.pdf,20488-46.pdf,20489-HSC_X.pdf,20524-GRT.pdf,20525-3.pdf,20532-scan0001.jpg,20532-scan0001.pdf,20532-scan0004.pdf,20541-scan0001.jpg,20541-scan0002.pdf,20541-scan0003.pdf,20547-LC.pdf,20547-SSC.pdf,20583-10th.pdf,20583-TC.pdf,20603-11.pdf,20606-HSC.pdf,20608-LC.pdf,20608-SSC.pdf,20617-10th.pdf,20617-12th.pdf,20617-MIG.pdf,20617-TC.pdf,20627-IMG_20230927_0001.pdf,20641-scan0001.jpg,20641-scan0001.pdf,20641-scan0002.pdf,20647-GRT.pdf,20649-LC.pdf,20649-SSC.pdf,20667-lc.pdf,20667-ssc.pdf,20671-Image.jpg,20671-MIGRATION.pdf,20671-SSC.pdf,20671-TC.pdf,20674-10th.pdf,20674-MIG.pdf,20674-TC.pdf,20683-lc.pdf,20683-ssc.pdf,20728-IMG_20230930_0001.pdf,20730-GRT_X.pdf,20749-lc.pdf,20749-ssc.pdf,20753-LC.pdf,20753-SSC.pdf,20759-MIG.pdf,20759-TC.pdf,20784-IMG_20230930_0001.pdf,20784-PASSING.pdf,20792-scan0002.pdf,20800-LC.pdf,20800-SSC.pdf,20803-HSC.pdf,20803-MIGRATION.pdf,20803-TC.pdf,20804-10th.pdf,20804-IMG_20231005_0001.jpg,20804-MIG.pdf,20804-TC.pdf,20815-10th.pdf,20815-12th.pdf,20815-IMG_20231005_0001.jpg,20819-scan0001.pdf,20819-scan0002.pdf,20820-10.pdf,20834-lc.pdf,20834-ssc.pdf,20836-21.pdf,20872-10th.pdf,20873-GRT.pdf,20879-10th.pdf,20879-12th.pdf,20879-IMG_20231006_0001.jpg,20900-LC.pdf,20900-P.jpg,20928-GAP.pdf,20928-PHOTO.jpg,20928-SSC.pdf,20928-TC.pdf,20956-47.pdf,20962-HSC.pdf,20962-LC.pdf,20962-SSC.pdf,20973-Image.jpg,20973-MIGRATION.pdf,20973-SSC.pdf,20973-TC.pdf,20976-SSC.pdf,21016-10th.pdf,21016-12th.pdf,21016-IMG_20231005_0001.jpg,21022-Z.pdf,21030-10th.pdf,21030-IMG_20231005_0001.jpg,21030-TC.pdf,21040-10th.pdf,21040-GAP.pdf,21040-TC.pdf,21046-HSC.pdf,21046-LC.pdf,21046-SSC.pdf,21049-Scaned_PDF.pdf,21068-10th.pdf,21068-GAP.pdf,21068-IMG_20231004_0001.jpg,21068-TC.pdf,21096-10th.pdf,21096-12th.pdf,21096-IMG_20231005_0001.jpg,21126-LC.pdf,21126-P_-_Copy.jpg,21130-GRT.pdf,21138-33.pdf,21158-10th.pdf,21158-12th.pdf,21158-IMG_20231007_0003.jpg,21161-12.pdf,21165-LC.pdf,21165-SSC.pdf,21167-12.pdf,21171-10.pdf,21189-DIP_compressed(44).pdf,21196-27.pdf,21199-scan0001.jpg,21199-scan0001.pdf,21199-scan0002.pdf,21217-IMG_20230923_0002_compressed.pdf,21221-10th.pdf,21227-GRT_compressed(40).pdf,21229-LC.pdf,21229-SSC.pdf,21241-CASTE.pdf,21241-GAP.pdf,21241-SSC.pdf,21241-SURAVASE_001.jpg,21241-TC.pdf,21241-VALIDITY.pdf,21245-hsc.pdf,21245-lc.pdf,21245-ssc.pdf,21263-Image.jpg,21263-MIGRATION.pdf,21263-SSC.pdf,21263-TC.pdf,21264-Image.jpg,21264-MIGRATION.pdf,21264-SSC.pdf,21264-TC.pdf,21276-HSC.pdf,21276-LC.pdf,21276-SSC.pdf,21299-scan0001.jpg,21299-scan0002.pdf,21299-scan0003.pdf,21302-LC.pdf,21302-SSC.pdf,21316-2.pdf,21337-LC.pdf,21337-SSC.pdf,21362-GRT.pdf,21367-10th.pdf,21367-IMG_20231004_0001.jpg,21367-MIG.pdf,21367-TC.pdf,21371-10th.pdf,21371-IMG_20231005_0001.jpg,21371-TC.pdf,21381-IMG_20231004_0001.jpg,21381-TC.pdf,21403-GRT.pdf,21423-LC.pdf,21423-SSC.pdf,21426-scan0001.jpg,21426-scan0001.pdf,21426-scan0002.pdf,21426-scan0003.pdf,21450-grt_compressed(37).pdf,21451-scan0001.jpg,21451-scan0001.pdf,21451-scan0002.pdf,21451-scan0003.pdf,21452-GRT.pdf,21456-GRT.pdf,21457-CASTE.pdf,21457-SSC.pdf,21457-TC.pdf,21458-CASTE.pdf,21458-Image.jpg,21458-SSC.pdf,21458-VALIDITY.pdf,21460-LC.pdf,21460-SSC.pdf,21477-LC.pdf,21477-SSC.pdf,21478-GRT.pdf,21478-PASSING.pdf,21482-6.pdf,21488-10th.pdf,21488-IMG_20231005_0001.jpg,21488-MIG.pdf,21488-TC.pdf,21496-GRT.pdf,21497-5.pdf,21504-43.pdf,21510-GRT_compressed(35).pdf,21512-GRT.pdf,21516-LC.pdf,21516-SSC.pdf,21521-GRT.pdf,21525-10th.pdf,21525-TC.pdf,21527-LC.pdf,21527-scan0001.jpg,21528-20.pdf,21530-DIP.pdf,21538-10th.pdf,21538-IMG_20231004_0001.jpg,21538-TC.pdf,21549-LC.pdf,21549-SSC.pdf,21555-10th.pdf,21555-IMG_20231006_0001.jpg,21555-TC.pdf,21560-11.pdf,21562-10th.pdf,21562-12th.pdf,21562-IMG_20231004_0001.jpg,21576-SSC.pdf,21579-DIP.pdf,21582-hsc.pdf,21582-lc.pdf,21582-ssc.pdf,21583-HSC_X.pdf,21583-hsc_x.pdf,21589-DEG.pdf,21589-GRT.pdf,21592-scan0001.pdf,21592-scan0002.pdf,21593-scan0002.pdf,21593-scan0003.pdf,21598-10th.pdf,21598-12th.pdf,21598-IMG_20231005_0001.jpg,21598-TC.pdf,21603-LC.pdf,21603-SSC.pdf,21605-39.pdf,21611-10th.pdf,21611-MIG.pdf,21611-TC.pdf,21615-IMG_20230930_0001.pdf,21620-LC.pdf,21620-SSC.pdf,21630-10th.pdf,21630-12th.pdf,21630-IMG_20231006_0001.jpg,21634-IMG_20230923_0001_compressed(21).pdf,21640-SSC.pdf,21640-scan0001.jpg,21645-DEG.pdf,21645-TC.pdf,21647-5.pdf,21650-10th.pdf,21650-TC.pdf,21657-lc.pdf,21657-ssc.pdf,21660-10th.pdf,21660-MIG.pdf,21660-TC.pdf,21662-10th.pdf,21662-IMG_20231005_0001.jpg,21662-MIG.pdf,21662-TC.pdf,21665-GRT.pdf,21679-10th.pdf,21679-12th.pdf,21679-IMG_20231005_0001.jpg,21679-TC.pdf,21683-HSC.pdf,21683-SSC.pdf,21701-10th.pdf,21701-MIG.pdf,21701-scan0001.jpg,21711-lc.pdf,21711-ssc.pdf,21716-10th.pdf,21716-12th.pdf,21716-IMG_20231006_0001.jpg,21716-TC.pdf,21718-10th.pdf,21718-12th.pdf,21718-IMG_20231004_0001.jpg,21725-scan0002.pdf,21726-HSC.pdf,21729-HSC.pdf,21734-lc3.pdf,21734-ssc.pdf,21741-10th.pdf,21741-IMG_20231004_0001.jpg,21741-TC.pdf,21756-23.pdf,21758-HSC.pdf,21760-9.pdf,21764-LC.pdf,21764-SSC.pdf,21775-GRT_X.pdf,21784-13.pdf,21794-scan0002.pdf,21794-scan0003.pdf,21796-LC.pdf,21796-SSC.pdf,21802-12.pdf,21810-4.pdf,21814-10th.pdf,21814-12th.pdf,21814-GAP.pdf,21814-IMG_20231005_0001.jpg,21814-TC.pdf,21820-3.pdf,21820-4.pdf,21823-2.pdf,21825-10th.pdf,21825-MIG.pdf,21825-TC.pdf,21826-GRT.pdf,21840-LC.pdf,21840-SSC.pdf,21863-31.pdf,21867-SSC.pdf,21868-scan0002.pdf,21868-scan0003.pdf,21869-GRT_compressed(33).pdf,21876-lc.pdf,21876-ssc.pdf,21878-MIGRATION.pdf,21878-SSC.pdf,21878-TC.pdf,21879-2.pdf,21882-lc.pdf,21882-ssc.pdf,21895-XX.pdf,21909-TC.pdf,21911-GRT.pdf,21912-7.pdf,21917-10th.pdf,21917-12th.pdf,21917-IMG_20231005_0001.jpg,21917-TC.pdf,21921-TC.pdf,21925-scan0001.pdf,21925-scan0003.pdf,21933-HSC.pdf,21937-scan0001.pdf,21943-hsc.pdf,21943-lc.pdf,21943-ssc.pdf,21946-10th.pdf,21946-MIG.pdf,21946-TC.pdf,21952-scan0002.pdf,21952-scan0003.pdf,21960-10th.pdf,21960-12th.pdf,21960-TC.pdf,21985-16.pdf,21989-scan0001.pdf,21989-scan0003.pdf,21990-ssc.pdf,21993-scan0002.pdf,21993-scan0003.pdf,21993-scan0004.pdf,21994-scan0002.pdf,21994-scan0003.pdf,21997-scan0002.pdf,21999-scan0004.pdf,21999-scan0005.pdf,22002-10th.pdf,22002-12th.pdf,22002-MIG.pdf,22002-TC.pdf,22006-HSC.pdf,22006-VALIDITY.pdf,22007-10th.pdf,22007-MIG.pdf,22007-TC.pdf,22014-lc.pdf,22014-ssc.pdf,22019-scan0002.pdf,22019-scan0003.pdf,22027-MIG.pdf,22027-TC.pdf,22029-IMG_20231006_0001.jpg,22029-TC.pdf,22037-scan0011.pdf,22037-scan0012.pdf,22039-3.pdf,22041-10th.pdf,22041-MIG.pdf,22041-TC.pdf,22047-10th.pdf,22047-MIG.pdf,22047-TC.pdf,22050-IMG_20230929_0002.pdf,22052-lc.pdf,22052-ssc.pdf,22057-scan0002.pdf,22057-scan0003.pdf,22063-GAP.pdf,22063-LC.pdf,22063-SSC.pdf,22082-10th.pdf,22082-MIG.pdf,22082-TC.pdf,22094-GRT.pdf,22095-scan0001.pdf,22095-scan0002.jpg,22096-hsc.pdf,22096-lc.pdf,22096-ssc.pdf,22099-10th.pdf,22099-IMG_20231005_0001.jpg,22099-TC.pdf,22102-10th.pdf,22102-12th.pdf,22103-ssc.pdf,22104-HSC.pdf,22104-LC.pdf,22104-SSC.pdf,22106-HSC.pdf,22113-scan0001.jpg,22113-scan0001.pdf,22113-scan0002.pdf,22114-scan0001.jpg,22114-scan0001.pdf,22114-scan0003.pdf,22114-scan0004.pdf,22126-scan0001.jpg,22126-scan0001.pdf,22126-scan0002.pdf,22126-scan0004.pdf,22134-GRT_X.pdf,22138-DIP_compressed(37).pdf,22144-scan0001.jpg,22144-scan0002.pdf,22144-scan0003.pdf,22147-14.pdf,22150-10th.pdf,22153-HSC.pdf,22153-LC.pdf,22153-SSC.pdf,22159-2.pdf,22160-10th.pdf,22160-IMG_20231005_0001.jpg,22160-TC.pdf,22161-10th.pdf,22161-MIG.pdf,22161-TC.pdf,22162-10th.pdf,22162-12th.pdf,22162-IMG_20231005_0001.jpg,22165-10th.pdf,22165-MIG.pdf,22165-TC.pdf,22168-4.pdf,22171-HSC_X.pdf,22179-HSC.pdf,22181-CASTE.pdf,22181-VALIDITY.pdf,22194-scan0001.jpg,22194-scan0002.pdf,22194-scan0003.pdf,22194-scan0004.pdf,22195-MIGRATION.pdf,22195-TC.pdf,22200-18.pdf,22202-GRT_X.pdf,22204-10th.pdf,22205-scan0001.jpg,22205-ssc.pdf,22208-scan0001.jpg,22208-scan0001.pdf,22208-scan0002.pdf,22208-scan0004.pdf,22209-HSC.pdf,22209-SSC.pdf,22214-10.pdf,22216-1.pdf,22222-LC.pdf,22222-ssc.pdf,22226-12th.pdf,22233-41.pdf,22234-10th.pdf,22234-IMG_20231006_0001.jpg,22234-TC.pdf,22238-lc.pdf,22238-ssc.pdf,22252-LC.pdf,22252-ssc.pdf,22256-HSC.pdf,22262-hsc.pdf,22262-lc.pdf,22262-ssc.pdf,22263-hsc.pdf,22263-ssc.pdf,22264-scan0001.pdf,22264-scan0002.jpg,22264-scan0002.pdf,22264-scan0003.pdf,22265-HSC.pdf,22265-SSC.pdf,22265-scan0001.jpg,22272-4.pdf,22274-10th.pdf,22274-12th.pdf,22274-IMG_20231006_0001.jpg,22274-TC.pdf,22313-10th.pdf,22313-IMG_20231005_0001.jpg,22314-hsc.pdf,22314-scan0001.jpg,22314-ssc.pdf,22321-10th.pdf,22321-12th.pdf,22321-Degree.pdf,22321-SSC.pdf,22321-TC.pdf,22321-scan0001.jpg,22325-scan0001.jpg,22325-scan0001.pdf,22325-scan0002.pdf,22325-scan0003.pdf,22328-ZZ.pdf,22331-MIG.pdf,22331-TC.pdf,22333-10th.pdf,22333-12th.pdf,22347-DIP.pdf,22351-26.pdf,22356-10th.pdf,22356-IMG_20231005_0001.jpg,22356-TC.pdf,22360-10th.pdf,22360-IMG_20231005_0001.jpg,22360-TC.pdf,22366-IMG_20230923_0001_compressed(12).pdf,22378-10th.pdf,22378-IMG_20231006_0001.jpg,22378-TC.pdf,22396-10th.pdf,22396-MIG.pdf,22396-TC.pdf,22398-10th.pdf,22398-12th.pdf,22398-HSC.pdf,22398-IMG_20231005_0004.pdf,22398-IMG_20231006_0001.jpg,22398-SSC.pdf,22400-IMG_20230923_0001_compressed(15).pdf,22404-5.pdf,22405-IMG_20230930_0001_compressed(13).pdf,22413-8.pdf,22425-IMG_20230923_0001_compressed(20).pdf,22427-lc.pdf,22427-ssc.pdf,22428-7.pdf,22432-RESULT.pdf,22435-10th.pdf,22435-IMG_20231006_0001.jpg,22435-MIG.pdf,22436-IMG_20230923_0001.pdf,22443-10th.pdf,22443-IMG_20231005_0001.jpg,22443-MIG.pdf,22443-TC.pdf,22450-10th.pdf,22450-IMG_20231005_0001.jpg,22450-MIG.pdf,22450-TC.pdf,22453-lc.pdf,22457-10th.pdf,22457-IMG_20231006_0004.jpg,22457-MIG.pdf,22457-TC.pdf,22467-10th.pdf,22467-IMG_20231006_0001.jpg,22467-MIG.pdf,22467-TC.pdf,22473-TC.pdf,22474-10th.pdf,22474-C.pdf,22474-tc.pdf,22475-10th.pdf,22475-IMG_20231005_0001.jpg,22475-MIG.pdf,22475-TC.pdf,22479-10th.pdf,22479-IMG_20231006_0001.jpg,22480-57.pdf,22482-10th.pdf,22482-IMG_20231005_0001.jpg,22482-MIG.pdf,22482-TC.pdf,22507-12th.pdf,22507-IMG_20231005_0001.jpg,22510-LC.pdf,22510-SSC.pdf,22513-TC.pdf,22514-37.pdf,22514-Image.jpg,22519-33.pdf,22523-IMG_20230923_0001_compressed(16).pdf,22527-10th.pdf,22527-IMG_20231005_0001.jpg,22527-MIG.pdf,22527-TC.pdf,22532-DIP.pdf,22536-LC.pdf,22536-SSC.pdf,22540-25.pdf,22545-10.pdf,22546-23.pdf,22559-IMG_20231006_0001.jpg,22559-TC.pdf,22560-10th.pdf,22560-IMG_20231005_0001.jpg,22560-TC.pdf,22566-HSC.pdf,22566-SSC.pdf,22567-10th.pdf,22567-IMG_20231005_0001.jpg,22567-TC.pdf,22569-10th.pdf,22569-IMG_20231006_0001.jpg,22569-TC.pdf,22570-11.pdf,22570-v.pdf,22577-13.pdf,22584-DIP_compressed(42).pdf,22585-Marksheet.pdf,22589-6.pdf,22593-10th.pdf,22593-IMG_20231005_0001.jpg,22593-TC.pdf,22598-16.pdf,22604-39.pdf,22614-1.pdf,22614-2.pdf,22614-3.pdf,22615-10th.pdf,22615-IMG_20231005_0001.jpg,22615-TC.pdf,22616-10th.pdf,22616-IMG_20231005_0001.jpg,22616-MIG.pdf,22616-TC.pdf,22619-BCOM.pdf,22619-BCOM_MARK_SHEET.pdf,22620-5.pdf,22625-10th.pdf,22625-12th.pdf,22625-230102061022.jpg,22625-TC.pdf,22626-HSC.pdf,22627-10th.pdf,22627-IMG_20231005_0001.jpg,22627-TC.pdf,22628-10th.pdf,22628-IMG_20231005_0002.jpg,22628-MIG.pdf,22628-TC.pdf,22631-10th.pdf,22631-IMG_20231006_0001.jpg,22631-TC.pdf,22632-GRT_compressed(41).pdf,22633-12.pdf,22633-HSC.pdf,22636-24.pdf,22639-DIP.pdf,22646-10th.pdf,22646-IMG_20231007_0001.jpg,22646-tc.pdf,22647-lc.pdf,22647-ssc.pdf,22648-10th.pdf,22648-TC.pdf,22649-10th.pdf,22649-IMG_20231005_0001.jpg,22651-LC.pdf,22651-SSC.pdf,22659-18.pdf,22660-10th.pdf,22660-12th.pdf,22660-IMG_20231006_0001.jpg,22660-TC.pdf,22661-16.pdf,22662-13.pdf,22662-Image.jpg,22665-LC.pdf,22665-SSC.pdf,22670-lc.pdf,22670-ssc.pdf,22672-30.pdf,22673-DIP.pdf,22675-12th.pdf,22675-AFFIDAVIT.pdf,22675-TC.pdf,22676-AS.pdf,22676-Conversion_from_cgpa_to_percentage_PD_BArch.pdf,22680-HSC.pdf,22683-GRT_compressed(38).pdf,22688-7.pdf,22691-hsc.pdf,22691-ssc.pdf,22694-lc.pdf,22694-ssc.pdf,22696-hsc.pdf,22696-lc.pdf,22696-ssc.pdf,22697-23.pdf,22709-44.pdf,22713-10th.pdf,22713-IMG_20231005_0001.jpg,22713-TC.pdf,22715-HSC_compressed(25).pdf,22717-3.pdf,22718-DIPLOMA.jpg,22719-10.pdf,22720-LC.pdf,22720-SSC.pdf,22721-45.pdf,22724-lc.pdf,22724-ssc.pdf,22726-IMG_20230930_0001_compressed(20).pdf,22727-4.pdf,22727-HSC.pdf,22727-SSC.pdf,22728-SSC.pdf,22730-10th.pdf,22730-IMG_20231005_0001.jpg,22730-TC.pdf,22731-LC.pdf,22731-SSC.pdf,22734-LC.pdf,22734-SSC.pdf,22736-lc.pdf,22736-ssc.pdf,22737-LC.pdf,22737-SSC.pdf,22739-1.pdf,22740-38.pdf,22741-DIP.pdf,22748-hsc.pdf,22748-lc.pdf,22748-ssc.pdf,22757-47.pdf,22763-10th.pdf,22763-12th.pdf,22763-MIG.pdf,22763-TC.pdf,22764-10TH.pdf,22764-TC.pdf,22770-10th.pdf,22770-12th.pdf,22770-TC.pdf,22775-4.pdf,22777-14.pdf,22779-10th.pdf,22779-12th.pdf,22779-IMG_20231005_0001.jpg,22779-TC.pdf,22782-MIGRATION.pdf,22786-55.pdf,22787-11.pdf,22788-6.pdf,22790-52.pdf,22805-10th.pdf,22805-12th.pdf,22805-TC.pdf,22807-HSC.pdf,22809-13.pdf,22810-IMG_20230926_0002.pdf,22812-CASTE.pdf,22812-HSC.pdf,22812-VALIDITY.pdf,22814-10th.pdf,22814-12th.pdf,22814-TC.pdf,22822-13.pdf,22826-22.pdf,22831-GRT.pdf,22833-DIP.pdf,22834-6.pdf,22836-IMG_20230930_0001_compressed(21).pdf,22838-DIP.pdf,22845-9.pdf,22850-IMG_20230923_0001_compressed(18).pdf,22858-49.pdf,22859-16.pdf,22862-31.pdf,22867-IMG_20230923_0001_compressed(14).pdf,22870-HSC.pdf,22871-IMG_20230929_0002_compressed(3).pdf,22872-18.pdf,22872-GRT.pdf,22872-SSC.pdf,22872-passing.pdf,22875-01.pdf,22886-DIP.pdf,22886-DIP_compressed(45).pdf,22887-HSC.pdf,22887-PASSING.pdf,22887-SSC.pdf,22887-YCMOU_GRT_compressed.pdf,22888-21.pdf,22888-y.pdf,22890-x.pdf,22892-29.pdf,22893-12.pdf,22894-17.pdf,22895-GRT.pdf,22896-28.pdf,22897-18.pdf,22898-IMG_20230923_0001_compressed(17).pdf,22899-HSC_compressed(24).pdf,22900-3.pdf,22901-9.pdf,22902-16.pdf,22903-DIP.pdf,22904-15.pdf,22905-IMG_20230923_0001_compressed(19).pdf,22906-DIP.pdf,22907-24.pdf,22908-36.pdf,22910-DIP_compressed(34).pdf,22911-DIP.pdf,22911-EWS.pdf,22912-12.pdf,22913-2.pdf,22914-IMG_20230923_0001_compressed(11).pdf,22915-20.pdf,22915-x.pdf,22917-19.pdf,22918-DIP.pdf,22919-DIP.pdf,22920-DIP.pdf,22921-DIP.pdf,22924-DIP_compressed(38).pdf,22925-DIP_compressed(35).pdf,22926-DIP_compressed(52).pdf,22927-IMG_20230923_0001.pdf,22928-IMG_20230923_0001_compressed(13).pdf,22929-IMG_20230923_0001.pdf,22930-IMG_20230930_0001_compressed(19).pdf,22931-44.pdf,22932-IMG_20230923_0002_compressed(1).pdf,22933-14.pdf,22934-IMG_20230923_0001_compressed(8).pdf,22935-DIP.pdf,22936-24.pdf,22937-IMG_20230923_0001_compressed(6).pdf,22938-1.pdf,22940-DIP.pdf,22941-DIP.pdf,22942-IMG_20230923_0001_compressed(5).pdf,22943-DIP.pdf,22944-DIP.pdf,22945-DIP.pdf,22946-DIP.pdf,22947-15.pdf,22949-29.pdf,22950-DIP.pdf,22951-22.pdf,22952-DIP.pdf,22953-DIP.pdf,22954-DIP.pdf,22955-54.pdf,22957-DIP.pdf,22958-DIP.pdf,22959-43.pdf,22960-DIP.pdf,22961-30.pdf,22963-GRT_compressed(34).pdf,22963-VALIDITY.pdf,22964-01.pdf,22965-28.pdf,22966-32.pdf,22970-DIP.pdf,22971-19.pdf,22972-17.pdf,22973-46.pdf,22975-DIP.pdf,22978-14.pdf,22979-15.pdf,22980-IMG_20231003_0001_compressed.pdf,22981-GRT.pdf,22982-DIP.pdf,22983-32.pdf,22988-41.pdf,22989-32.pdf,22990-51.pdf,22991-12.pdf,22992-IMG_20230929_0002_compressed(1).pdf,22993-DIP_compressed(41).pdf,22995-14.pdf,23000-IMG_20230930_0001.pdf,23001-DIP.pdf,23002-IMG_20230927_0001_compressed(1).pdf,23003-DIP.pdf,23004-DIP.pdf,23005-DIP.pdf,23006-3.pdf,23007-DIP.pdf,23008-BIRTH_CERTIFICATE.pdf,23008-DIP.pdf,23008-GRT.pdf,23008-HSC.pdf,23008-IMG_20230923_0002.jpg,23008-PASSPORT.pdf,23008-SCHOOL_CERTIFICATE.pdf,23008-VISA.pdf,23010-1.pdf,23012-29.pdf,23013-DIP.pdf,23014-DIP.pdf,23017-IMG_20230929_0002_compressed(4).pdf,23021-DIP.pdf,23022-22.pdf,23024-13.pdf,23027-40.pdf,23028-34.pdf,23029-34.pdf,23030-33.pdf,23031-21.pdf,23032-HSC_C.pdf,23033-37.pdf,23034-45.pdf,23035-5.pdf,23037-8.pdf,23039-8.pdf,23042-IMG_20230930_0003_compressed.pdf,23043-8.pdf,23044-20.pdf,23045-8.pdf,23046-6.pdf,23047-7.pdf,23048-4.pdf,23050-3.pdf,23052-5.pdf,23053-DIP.pdf,23054-DIP.pdf,23055-9.pdf,23056-DIP.pdf,23057-2.pdf,23058-35.pdf,23059-50.pdf,23060-7.pdf,23061-23.pdf,23064-1.pdf,23065-GRT.pdf,23065-HSC.pdf,23065-PG.pdf,23065-SSC.pdf,23066-GRT.pdf,23066-PG_X.pdf,23067-3.pdf,23070-24.pdf,23071-18.pdf,23072-19.pdf,23073-25.pdf,23074-42.pdf,23075-26.pdf,23076-28.pdf,23078-6.pdf,23079-8.pdf,23079-Image.jpg,23080-17.pdf,23081-16.pdf,23082-16.pdf,23083-DIP.pdf,23084-26.pdf,23087-DIP_compressed(36).pdf,23089-DIP.pdf,23090-GRT.pdf,23092-30.pdf,23093-CHARACTER_CERTIFICATE.pdf,23093-HSC.pdf,23093-ID_CARD_NEPAL_GOVT.pdf,23093-IMG_20230927_0002.jpg,23093-MIGRATION.pdf,23093-PASSPORT.pdf,23093-SSC.pdf,23094-DIP.pdf,23095-IMG_20230929_0002_compressed(5).pdf,23096-HSC.pdf,23097-10.pdf,23099-11.pdf,23100-15.pdf,23102-34.pdf,23109-HSC_X_compressed(9).pdf,23110-31.pdf,23112-33.pdf,23114-IMG_20230929_0002_compressed(2).pdf,23116-IMG_20230930_0001_compressed(23).pdf,23117-8.pdf,23118-DIP.pdf,23119-35.pdf,23120-7.pdf,23122-DIP.pdf,23123-IMG_20230930_0001_compressed(24).pdf,23127-42.pdf,23130-50.pdf,23131-40.pdf,23133-1.pdf,23135-GRT.pdf,23135-PG.pdf,23138-9.pdf,23139-11.pdf,23141-14.pdf,23146-HSC.pdf,23147-20.pdf,23150-DIP.pdf,23151-6.pdf,23151-C.pdf,23153-1.pdf,23154-8.pdf,23155-6.pdf,23157-11.pdf,23158-35.pdf,23166-13.pdf,23167-14.pdf,23169-HSC.pdf,23170-19.pdf,23171-22.pdf,23172-GRT_X.pdf,23175-GRT.pdf,23176-GRT.pdf,23181-GRT.pdf,23183-DIP.pdf,23184-HSC_X.pdf,23185-DIP.pdf,23188-DGR.pdf,23188-GAZ_compressed.pdf,23188-GRT_compressed(44).pdf,23189-DIP_compressed(49).pdf,23194-GRT.pdf,23194-PASSING.pdf,23194-VI_SEM.pdf,23196-HSC.pdf,23199-HSC.pdf,23203-LLB.pdf,23204-Scaned_PDF.pdf,23205-GRT.pdf,23206-HSC.pdf,23207-HSC.pdf,4706-IMG_20230923_0003.jpg,6719-IMG_20230922_0002.jpg,7400-Screenshot_2023-09-26-11-40-40-86_c37d74246d9c81aa0bb824b57eaf7062.jpg";
        $file_arr = explode(',', $file_string);
        
        $Ignore = array(".","..","Thumbs.db");
        $OriginalFileRoot = "/var/www/html/suproject/project/erp/uploads/student_document";
        
        $DestinationRoot = "/var/www/html/suproject/project/erp/uploads/backup";
        //var_dump($file_arr);die();
        try{
            foreach($file_arr as $failed_file_str){
               
                    try{
                        echo $DestinationFile = $DestinationRoot. "/". $failed_file_str; // Create the destination filename    
                        echo "<br/>";
                        copy($OriginalFileRoot."/".$failed_file_str, $DestinationFile);
                    }catch(Exception $e){
                        echo $failed_file_str."<br/>";
                        //echo "exception".$e->getMessage();
                    }
                
            }
        }catch(Exception $e){
            echo "exception occured";
        }
    }
}
