/**
 *	官网：http://www.5bkk.com
 *  Author : zhangxudong
 *  time : 2016-7-18
 *  s3文件上传
 *  使用案例
 *	 var button = document.getElementById('upload-button');
 *	button.addEventListener('click', function() {
 *		var a = awsUpload.upload('file-chooser', callback, success);
 *	});
 *
 *	function callback(total, load){
 *		awsUpload.getElement('load').innerHTML = load*100/total;
 *	}
 *	
 *	function success(err, data, url){
 *		if( err ){
 *			alert('错啦')
 *		}else{
 *			console.log(url)
 *		}
 *	}
 */

var awsUpload = {
	// 秘钥
	keyId : 'AKIAI3P25R7JQIO43LLQ',
	// secret
	secret : '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',
	// 桶名称
	bucket : 'sod-live-pc',
	// 地区
	 region : 'ap-southeast-1' ,
	// 文件路径
	filePath : 'System/Picture/',
	//权限控制
	//ACL : 'private',
	ACL : 'public-read-write',

	// 错误设置
	error : '',

	// 上传对象
	loadObj : [],

	// 获取对象
	getElement : function( objName ){
		return document.getElementById( objName );
	},

	/**
	 * 上传文件
	 * @param string objName
	 * @param function callBack
	 * @param function success
	 * @param function file  上传文件类型 
	 * @param function rename  是否重命名
	 * return boolean
	 */
	upload : function( objName, callBack, success, file,rename ){
		
			//根据文件后缀名选择S3保存的路径	
		switch(file){
			case 1:
				this.filePath = 'System/Video/';
				break;
			case 2:
				this.filePath = 'System/Picture/';
				break;
			default:
				this.filePath = 'System/Web/';
		}	
		
		console.log('objName:'+objName);
		// 获取对象
		var obj  = this.getElement( objName ),type = file;
		if(obj == null)  obj = objName;		
		
		var	file = obj.files[0], self = this, urls = {totalUrl:'',partUrl:''};
		
		//如果文件名已经存在，删除S3上的文件 
		if( this.loadObj[objName] )
			this.loadObj[objName].abort();

		if( file ){
			
			//判断是否重命名 rename = 1 使用原名 ，其他重命名 
			if(rename == 1){
				var fname = file.name;
			}else{
				var fname = this.resetName(file.name);
			}
			
			this.loadObj[objName+'file'] = this.filePath;
			console.log(type); 
			//return false;
			//如果是mp4 格式 启用分片上传
			if(type < 0 ){
				
				this.keyName = this.filePath+fname;
				var params = {Bucket: this.bucket,Key: this.keyName, Body: file };
				var options = {partSize: 5 * 1024 * 1024 , queueSize: 10}; //分片上传参数设置  5M 10个并发
							
				this.loadObj[objName] =	 this.getS3().upload(params, options, function(err, data) {
					
					if( typeof success == 'function' ){
						
						if (err){
							console.log('1:'+objName);
							success.call( self, err, data, objName );
						}else{
							//设置权限
						 	 urls.partUrl = data.Key;	
							 self.putAcl(self.bucket,data.Key,self.ACL,self,data,urls,objName);
						}
					}
				});
			}else{
				//普通上传
				this.loadObj[objName] = this.getS3().putObject( {Key:this.filePath+fname, Body: file ,ACL:this.ACL} );
			
				this.loadObj[objName].send(function (err, data) {
					if( typeof success == 'function' ){
						if (err){
							console.log('2:'+objName);
							success.call( self, err, data, objName );
						}else{
							/* {Key: 'myKey', Expires: 60} set Expires time */
							self.getS3().getSignedUrl('getObject', {Key:self.loadObj[objName+'file']+fname},
							function (err, url) {
								urls.totalUrl = url.substr( 0, url.indexOf('?') );
							});
							urls.partUrl = self.loadObj[objName+'file']+fname;
							console.log('3:'+objName);
							success.call( self, err, data, urls, objName);
						}
					}
				});
			}

			// 进度监听
			this .uploadLister( this.loadObj[objName], objName, callBack );
		}else{
			this. setError( '文件不存在' );
			return false;
		}
	},
	//设置文件权限
	putAcl : function(Bucket,Key,ACL,self,data,urls,objName){
			var params = {Bucket:Bucket,Key: Key, ACL:ACL};
			self.getS3().putObjectAcl(params, function(err11, data11) {
			  if (err11){
				  console.log('设置权限失败：'+Key);
				  self.putAcl(Bucket,Key,ACL,self);
				  console.log('4:'+objName);
				  console.log(err11, err11.stack); // an error occurred
			  }else {
				 success.call( self, err11, data, urls, objName);
				 console.log('设置权限成功：'+Key);
				}
			});
	},
	

	/**
	 * 终止文件上传
	 @ param objName string 终止对象的名称
	 return boolean
	 */
	 abortUpFile : function ( objName ) {
		if( this.loadObj[objName] ){
			this.loadObj[objName].abort();
			return true;
		} else {
			return false;
		}
	 },

	/**
	 * 文件重命名
	 * @param string fileName
	 * return string
	 */
	resetName : function( fileName ){
		var fix = fileName.substr( fileName.lastIndexOf('.') );
		var str = String(Math.random()).substr( String(Math.random()).lastIndexOf('.')+1 );
		str += String( new Date().getTime() );
		str += fix;
		return str;
	},

	/**
	 * 跟踪上传进度
	 * @param Object object
	 * @param string name
	 * @param function callBack
 	 */
	uploadLister : function( object, name, callBack ){
		var self = this;
		object.on('httpUploadProgress',function( data ){
			if( typeof callBack == 'function' ){
				callBack.call(self, data.total, data.loaded, name);
			}
		});
	},

	/**
	 * flag设置为true直接返回错误信息
	 * 设置为false则为对象显示
	 * return maxed
	 */
	getError : function(){
		return this.error;
	},

	/**
	 * 设置错误信息
	 * @param string error
	 * return void
	 */
	setError : function( error ){
		this.error = error;
	},

	/**
	 * 获取s3对象
	 */
	getS3 : function(){
		AWS.config.update({accessKeyId: this.keyId, secretAccessKey: this.secret});
		// 设置文件上传超时时间
		AWS.config.httpOptions.timeout = 12000000000;

		AWS.config.region = this.region;
		return new AWS.S3({params: {Bucket: this.bucket}});
	},

	/**
	 * 获取下载链接
	 * string name
	 * int expires
	 */
	getDowloadUrl : function( name, expires ){
		/* {Key: 'myKey', Expires: 60} set Expires time */
		var urls, expires = expires || 60;
		this.getS3().getSignedUrl('getObject', {Key:name, Expires:expires},
		function (err, url) {
			urls = url
		});
		return urls;
	},

	/**
	 * 获取文件索引id
	 */
	getFileIndex : function( fileName ){
		var index='';

		this.getS3().getObjectAcl({Key: fileName}, function(err, data) {
		  if (err){
			  console.log(err, err.stack);
		  }else{
			  index = data.Owner.ID;
		  }
		});

		return index;
	},
	
	/**
	 * 分片上传 
	 **/
	 uploadPart : function (fname, file) {
		 
		 //	this.loadObj[objName] = this.getS3().putObject( {Key:this.filePath+fname, Body: file ,ACL:this.ACL} );
		
		 console.log(file);
		 UploadId = String( new Date().getTime() )  ;
		  console.log( UploadId );
		var params = {
		  Bucket: this.bucket, /* required */
		  Key:this.filePath+fname, /* required */
		//  ACL:this.ACL,
		  PartNumber: 0, /* required */
		  UploadId: UploadId, /* required */
		  Body: file,
		  ContentLength: 5*1024, //5M 
		//  ContentMD5: 'STRING_VALUE',
		//  RequestPayer: requester,
		  SSECustomerAlgorithm: 'AES256',
		 SSECustomerKey: 'g0lCfA3Dv40jZz5SQJ1ZukLRFqtI5WorC/8SEEXAMPLE',
		  SSECustomerKeyMD5: 'ZjQrne1X/iTcskbY2example'
		};
		this.getS3().uploadPart(params, function(err, data) {
			 console.log('test-----------');
		  if (err) console.log(err, err.stack); // an error occurred
		  else     console.log(data);           // successful response
		});
	}
};