
    var gl;

    function initGL(canvas) {
        try {
            gl = canvas.getContext("experimental-webgl");
            gl.viewportWidth = canvas.width;
            gl.viewportHeight = canvas.height;
        } catch (e) {
        }
        if (!gl) {
            alert("Could not initialise WebGL..!!!!");
        }
    }


    function getShader(gl, id) {
        var shaderScript = document.getElementById(id);
        if (!shaderScript) {
            return null;
        }

        var str = "";
        var k = shaderScript.firstChild;
        while (k) {
            if (k.nodeType == 3) {
                str += k.textContent;
            }
            k = k.nextSibling;
        }

        var shader;
        if (shaderScript.type == "x-shader/x-fragment") {
            shader = gl.createShader(gl.FRAGMENT_SHADER);
        } else if (shaderScript.type == "x-shader/x-vertex") {
            shader = gl.createShader(gl.VERTEX_SHADER);
        } else {
            return null;
        }

        gl.shaderSource(shader, str);
        gl.compileShader(shader);

        if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
            alert(gl.getShaderInfoLog(shader));
            return null;
        }

        return shader;
    }


    var shaderProgram;

    function initShaders() {
        var fragmentShader = getShader(gl, "shader-fs");
        var vertexShader = getShader(gl, "shader-vs");

        shaderProgram = gl.createProgram();
        gl.attachShader(shaderProgram, vertexShader);
        gl.attachShader(shaderProgram, fragmentShader);
        gl.linkProgram(shaderProgram);

        if (!gl.getProgramParameter(shaderProgram, gl.LINK_STATUS)) {
            alert("Could not initialise shaders");
        }

        gl.useProgram(shaderProgram);

        shaderProgram.vertexPositionAttribute = gl.getAttribLocation(shaderProgram, "aVertexPosition");
        gl.enableVertexAttribArray(shaderProgram.vertexPositionAttribute);

        shaderProgram.textureCoordAttribute = gl.getAttribLocation(shaderProgram, "aTextureCoord");
        gl.enableVertexAttribArray(shaderProgram.textureCoordAttribute);

        shaderProgram.pMatrixUniform = gl.getUniformLocation(shaderProgram, "uPMatrix");
        shaderProgram.mvMatrixUniform = gl.getUniformLocation(shaderProgram, "uMVMatrix");
        shaderProgram.samplerUniform = gl.getUniformLocation(shaderProgram, "uSampler");
    }


    function handleLoadedTexture(texture) {
        gl.pixelStorei(gl.UNPACK_FLIP_Y_WEBGL, true);
        gl.bindTexture(gl.TEXTURE_2D, texture);
        gl.texImage2D(gl.TEXTURE_2D, 0, gl.RGBA, gl.RGBA, gl.UNSIGNED_BYTE, texture.image);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MAG_FILTER, gl.LINEAR);
        gl.texParameteri(gl.TEXTURE_2D, gl.TEXTURE_MIN_FILTER, gl.LINEAR);

        gl.bindTexture(gl.TEXTURE_2D, null);
    }




    var mudTexture;

    function initTexture() {
        mudTexture = gl.createTexture();
        mudTexture.image = new Image();
        mudTexture.image.onload = function () {
            handleLoadedTexture(mudTexture);
        };

        mudTexture.image.src = "./Resources/TextureImages/mud.gif";
		//mudTexture.image.src = "floor.gif";
    }
    
    var floorTexture;

    function initFloorTexture() {
        floorTexture = gl.createTexture();
        floorTexture.image = new Image();
        floorTexture.image.onload = function () {
            handleLoadedTexture(floorTexture);
        };

        floorTexture.image.src = "./Resources/TextureImages/floor.png";
		//mudTexture.image.src = "floor.gif";
    }



    var roofTexture;

    function initRoofTexture() {
        roofTexture = gl.createTexture();
        roofTexture.image = new Image();
        roofTexture.image.onload = function () {
            handleLoadedTexture(roofTexture);
        };

        roofTexture.image.src = "./Resources/TextureImages/roof.png";
		//mudTexture.image.src = "floor.gif";
    }


    var backTexture;

    function initBackTexture() {
        backTexture = gl.createTexture();
        backTexture.image = new Image();
        backTexture.image.onload = function () {
            handleLoadedTexture(backTexture);
        };

        backTexture.image.src = "./Resources/TextureImages/back.png";
		//mudTexture.image.src = "floor.gif";
    }



    var frontTexture;

    function initFrontTexture() {
        frontTexture = gl.createTexture();
        frontTexture.image = new Image();
        frontTexture.image.onload = function () {
            handleLoadedTexture(frontTexture);
        };

        frontTexture.image.src = "./Resources/TextureImages/front.png";
		//mudTexture.image.src = "floor.gif";
    }



    var leftTexture;

    function initLeftTexture() {
        leftTexture = gl.createTexture();
        leftTexture.image = new Image();
        leftTexture.image.onload = function () {
            handleLoadedTexture(leftTexture);
        };

        leftTexture.image.src = "./Resources/TextureImages/left.png";
		//mudTexture.image.src = "floor.gif";
    }
    
    var rightTexture;

    function initRightTexture() {
        rightTexture = gl.createTexture();
        rightTexture.image = new Image();
        rightTexture.image.onload = function () {
            handleLoadedTexture(rightTexture);
        };

        rightTexture.image.src = "./Resources/TextureImages/right.png";
		//mudTexture.image.src = "floor.gif";
    }
    
    
    

    var mvMatrix = mat4.create();
    var mvMatrixStack = [];
    var pMatrix = mat4.create();

    function mvPushMatrix() {
        var copy = mat4.create();
        mat4.set(mvMatrix, copy);
        mvMatrixStack.push(copy);
    }

    function mvPopMatrix() {
        if (mvMatrixStack.length == 0) {
            throw "Invalid popMatrix!";
        }
        mvMatrix = mvMatrixStack.pop();
    }


    function setMatrixUniforms() {
        gl.uniformMatrix4fv(shaderProgram.pMatrixUniform, false, pMatrix);
        gl.uniformMatrix4fv(shaderProgram.mvMatrixUniform, false, mvMatrix);
    }


    function degToRad(degrees) {
        return degrees * Math.PI / 180;
    }



    var currentlyPressedKeys = {};

    function handleKeyDown(event) {
        currentlyPressedKeys[event.keyCode] = true;
    }


    function handleKeyUp(event) {
        currentlyPressedKeys[event.keyCode] = false;
    }


    var pitch = 0;
    var pitchRate = 0;

    var yaw = 0;
    var yawRate = 0;

    var xPos = 0;
    var yPos = 0.4;
    var zPos = 2;

    var speed = 0;

    function handleKeys() {
        if (currentlyPressedKeys[33]) {
            // Page Up
            pitchRate = 0.1;
        } else if (currentlyPressedKeys[34]) {
            // Page Down
            pitchRate = -0.1;
        } else {
            pitchRate = 0;
        }

        if (currentlyPressedKeys[37]) {
            // Left cursor key
            yawRate = 0.1;
        } else if (currentlyPressedKeys[39]) {
            // Right cursor key
            yawRate = -0.1;
        } else {
            yawRate = 0;
        }

        if (currentlyPressedKeys[38]) {
            // Up cursor key
            speed = 0.003;
        } else if (currentlyPressedKeys[40]) {
            // Down cursor key
            speed = -0.003;
        } else {
            speed = 0;
        }

    }


    var worldVertexPositionBuffer = null;
    var worldVertexTextureCoordBuffer = null;

    function handleLoadedWorld(data) {
        var lines = data.split("\n");
        var vertexCount = 0;
        var vertexPositions = [];
        var vertexTextureCoords = [];


        var vertexCount1 = 0;
        var vertexPositions1 = [];
        var vertexTextureCoords1 = [];


        var vertexCount2 = 0;
        var vertexPositions2 = [];
        var vertexTextureCoords2 = [];

        var vertexCount3 = 0;
        var vertexPositions3 = [];
        var vertexTextureCoords3 = [];

        var vertexCount4 = 0;
        var vertexPositions4 = [];
        var vertexTextureCoords4 = [];


        var vertexCount5 = 0;
        var vertexPositions5 = [];
        var vertexTextureCoords5 = [];

        var vertexCount6 = 0;
        var vertexPositions6 = [];
        var vertexTextureCoords6 = [];

        

        count=0;
        
        for (var i in lines) {
            if(count>72){
            	//document.getElementById('ycord').innerHTML=lines[i];
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            //document.getElementById('ycord').innerHTML=lines[i];
	            if (vals.length == 5 && vals[0] != "//") {
	                // It is a line describing a vertex; get X, Y and Z first
	                vertexPositions.push(parseFloat(vals[0]));
	                vertexPositions.push(parseFloat(vals[1]));
	                vertexPositions.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords.push(parseFloat(vals[3]));
	                vertexTextureCoords.push(parseFloat(vals[4]));
	
	                vertexCount += 1;
	            }
            }
            else if(count>60){
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {
	                // It is a line describing a vertex; get X, Y and Z first
	                vertexPositions6.push(parseFloat(vals[0]));
	                vertexPositions6.push(parseFloat(vals[1]));
	                vertexPositions6.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords6.push(parseFloat(vals[3]));
	                vertexTextureCoords6.push(parseFloat(vals[4]));
	
	                vertexCount6 += 1;
	            }
            	
            }
            else if(count>49){
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {
	                // It is a line describing a vertex; get X, Y and Z first
	                vertexPositions5.push(parseFloat(vals[0]));
	                vertexPositions5.push(parseFloat(vals[1]));
	                vertexPositions5.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords5.push(parseFloat(vals[3]));
	                vertexTextureCoords5.push(parseFloat(vals[4]));
	
	                vertexCount5 += 1;
	            }
                
            }
            else if(count>29){
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {
	                // It is a line describing a vertex; get X, Y and Z first
	                vertexPositions4.push(parseFloat(vals[0]));
	                vertexPositions4.push(parseFloat(vals[1]));
	                vertexPositions4.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords4.push(parseFloat(vals[3]));
	                vertexTextureCoords4.push(parseFloat(vals[4]));
	
	                vertexCount4 += 1;
	            }

            }
            else if(count>18){
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {
	                // It is a line describing a vertex; get X, Y and Z first
	                vertexPositions3.push(parseFloat(vals[0]));
	                vertexPositions3.push(parseFloat(vals[1]));
	                vertexPositions3.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords3.push(parseFloat(vals[3]));
	                vertexTextureCoords3.push(parseFloat(vals[4]));
	
	                vertexCount3 += 1;
	            }

            }

            else if(count>10){
	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {

	                vertexPositions2.push(parseFloat(vals[0]));
	                vertexPositions2.push(parseFloat(vals[1]));
	                vertexPositions2.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords2.push(parseFloat(vals[3]));
	                vertexTextureCoords2.push(parseFloat(vals[4]));
	
	                vertexCount2 += 1;
	            }
			}

            
            else{

	            var vals = lines[i].replace(/^\s+/, "").split(/\s+/);
	            if (vals.length == 5 && vals[0] != "//") {

	                vertexPositions1.push(parseFloat(vals[0]));
	                vertexPositions1.push(parseFloat(vals[1]));
	                vertexPositions1.push(parseFloat(vals[2]));
	
	                // And then the texture coords
	                vertexTextureCoords1.push(parseFloat(vals[3]));
	                vertexTextureCoords1.push(parseFloat(vals[4]));
	
	                vertexCount1 += 1;
	            }
                
            }
            count+=1;
        }

        worldVertexPositionBuffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions), gl.STATIC_DRAW);
        worldVertexPositionBuffer.itemSize = 3;
        worldVertexPositionBuffer.numItems = vertexCount;

        worldVertexTextureCoordBuffer = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer.itemSize = 2;
        worldVertexTextureCoordBuffer.numItems = vertexCount;


        worldVertexPositionBuffer1 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer1);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions1), gl.STATIC_DRAW);
        worldVertexPositionBuffer1.itemSize = 3;
        worldVertexPositionBuffer1.numItems = vertexCount1;

        worldVertexTextureCoordBuffer1 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer1);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords1), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer1.itemSize = 2;
        worldVertexTextureCoordBuffer1.numItems = vertexCount1;



        worldVertexPositionBuffer2 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer2);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions2), gl.STATIC_DRAW);
        worldVertexPositionBuffer2.itemSize = 3;
        worldVertexPositionBuffer2.numItems = vertexCount2;

        worldVertexTextureCoordBuffer2 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer2);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords2), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer2.itemSize = 2;
        worldVertexTextureCoordBuffer2.numItems = vertexCount2;




        worldVertexPositionBuffer3 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer3);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions3), gl.STATIC_DRAW);
        worldVertexPositionBuffer3.itemSize = 3;
        worldVertexPositionBuffer3.numItems = vertexCount3;

        worldVertexTextureCoordBuffer3 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer3);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords3), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer3.itemSize = 2;
        worldVertexTextureCoordBuffer3.numItems = vertexCount3;


        worldVertexPositionBuffer4 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer4);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions4), gl.STATIC_DRAW);
        worldVertexPositionBuffer4.itemSize = 3;
        worldVertexPositionBuffer4.numItems = vertexCount4;

        worldVertexTextureCoordBuffer4 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer4);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords4), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer4.itemSize = 2;
        worldVertexTextureCoordBuffer4.numItems = vertexCount4;



        worldVertexPositionBuffer5 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer5);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions5), gl.STATIC_DRAW);
        worldVertexPositionBuffer5.itemSize = 3;
        worldVertexPositionBuffer5.numItems = vertexCount5;

        worldVertexTextureCoordBuffer5 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer5);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords5), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer5.itemSize = 2;
        worldVertexTextureCoordBuffer5.numItems = vertexCount5;



        



        worldVertexPositionBuffer6 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer6);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexPositions6), gl.STATIC_DRAW);
        worldVertexPositionBuffer6.itemSize = 3;
        worldVertexPositionBuffer6.numItems = vertexCount6;

        worldVertexTextureCoordBuffer6 = gl.createBuffer();
        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer6);
        gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(vertexTextureCoords6), gl.STATIC_DRAW);
        worldVertexTextureCoordBuffer6.itemSize = 2;
        worldVertexTextureCoordBuffer6.numItems = vertexCount6;
        







        

        document.getElementById("loadingtext").textContent = "";
    }


    function loadWorld() {
        var request = new XMLHttpRequest();
        var request1 = new XMLHttpRequest();
        request.open("GET", "./Resources/world.txt");
        request1.open("GET", "floor_text.txt");
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                handleLoadedWorld(request.responseText);
            }
        };
        request.send();
    }


    /*
    
    function loadFloor() {
        var request = new XMLHttpRequest();
        request.open("GET", "floor_text.txt");
        request.onreadystatechange = function () {
            if (request.readyState == 4) {
                handleLoadedWorld(request.responseText);
            }
        }
        request.send();
    }



    */
    
    
    function drawScene() {
        var number=2;
        gl.viewport(0, 0, gl.viewportWidth, gl.viewportHeight);
        gl.clear(gl.COLOR_BUFFER_BIT | gl.DEPTH_BUFFER_BIT);

        if (worldVertexTextureCoordBuffer == null || worldVertexPositionBuffer == null) {
            return;
        }

        mat4.perspective(45, gl.viewportWidth / gl.viewportHeight, 0.1, 100.0, pMatrix);

        mat4.identity(mvMatrix);

        mat4.rotate(mvMatrix, degToRad(-pitch), [1, 0, 0]);
        mat4.rotate(mvMatrix, degToRad(-yaw), [0, 1, 0]);
        mat4.translate(mvMatrix, [-xPos, -yPos, -zPos]);

        //document.getElementById('ycord').innerHTML=fg[14];

        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, floorTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer.numItems);





        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, floorTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer1);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer1.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer1);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer1.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer1.numItems);




        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, roofTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer2);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer2.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer2);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer2.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer2.numItems);



        

        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, backTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer3);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer3.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer3);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer3.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer3.numItems);



        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, frontTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer4);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer4.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer4);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer4.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer4.numItems);



        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, leftTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer5);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer5.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer5);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer5.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer5.numItems);




        gl.activeTexture(gl.TEXTURE0);

        gl.bindTexture(gl.TEXTURE_2D, rightTexture);
        //gl.bindTexture(gl.TEXTURE_2D, floorTexture);

        gl.uniform1i(shaderProgram.samplerUniform, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexTextureCoordBuffer6);
        gl.vertexAttribPointer(shaderProgram.textureCoordAttribute, worldVertexTextureCoordBuffer5.itemSize, gl.FLOAT, false, 0, 0);

        gl.bindBuffer(gl.ARRAY_BUFFER, worldVertexPositionBuffer6);
        gl.vertexAttribPointer(shaderProgram.vertexPositionAttribute, worldVertexPositionBuffer6.itemSize, gl.FLOAT, false, 0, 0);

        setMatrixUniforms();
        gl.drawArrays(gl.TRIANGLES, 0, worldVertexPositionBuffer6.numItems);








        
    }


    var lastTime = 0;
    // Used to make us "jog" up and down as we move forward.
    var joggingAngle = 0;

    function animate() {
        var timeNow = new Date().getTime();
        if (lastTime != 0) {
            var elapsed = timeNow - lastTime;

            if (speed != 0) {
                xPos -= Math.sin(degToRad(yaw)) * speed * elapsed;
                zPos -= Math.cos(degToRad(yaw)) * speed * elapsed;

                joggingAngle += elapsed * 0.6; // 0.6 "fiddle factor" - makes it feel more realistic :-)
                yPos = Math.sin(degToRad(joggingAngle)) / 20 + 0.4;
            }

            yaw += yawRate * elapsed;
            pitch += pitchRate * elapsed;

        }
        lastTime = timeNow;
    }


    function tick() {
        requestAnimFrame(tick);
        handleKeys();
        drawScene();
        animate();
    }













    var mouseDown = false;
    var lastMouseX = null;
    var lastMouseY = null;

    function handleMouseDown(event) {
        mouseDown = true;
        lastMouseX = event.clientX;
        lastMouseY = event.clientY;
        get_cordinates(lastMouseX,lastMouseY);
        get3dPoint(lastMouseX,lastMouseY);
    }


    function handleMouseUp(event) {
        mouseDown = false;
    }


    function handleMouseMove(event) {
        if (!mouseDown) {
            return;
        }
        var newX = event.clientX;
        var newY = event.clientY;

        get_cordinates(newX,newY);

        get3dPoint(newX,newY);

		
    }





	function get_cordinates(newX,newY) {
		var a = String(newX)+"--"+String(newY);
		//document.getElementById('xcord').innerHTML=a;;
		//document.getElementById('ycord').innerHTML=newY;
	}



/*
	function print_selected_password(){
		var ad="";
		for(var i=0;i<interact.length;i++){
			ad=ad+interact[i];
			ad=ad+"--";
		}
		document.getElementById('ycord').innerHTML=ad;
	}*/


	/*
	

	function pick_3d_cube(xqcord,yqcord,zqcord){

		//document.getElementById('xcord').innerHTML=zqcord;

		//document.getElementById('ycord').innerHTML=zqcord;
		//document.getElementById('ycord').innerHTML="count";
		
		var numb;
		var ss=String(xqcord)+"qw"+String(yqcord)+"qw"+String(zqcord);

		document.getElementById('ycord').innerHTML=ss;
		
		var count = 0;

		for(var i=-7.7;i<7.7;i=i+0.3){
			//document.getElementById('ycord').innerHTML=count;
			//for(var j=-6.8;j<6.8;j=j+0.3){
				//document.getElementById('ycord').innerHTML=count;
				//for(var k=-10.6;k<10.6;k=k+0.3){
					//document.getElementById('ycord').innerHTML=count;

					if(((xqcord>i )&& xqcord<(i+0.2))){// &&  (yqcord>j && yqcord<(j+0.2))) || ((zqcord>k && zqcord<(k+0.2)) && (xqcord>i && xqcord<(i+0.2))) || ( (zqcord>k && zqcord<(k+0.2)) && (yqcord>j && yqcord<(j+0.2)) ) ){
						//document.getElementById('ycord').innerHTML=count;
						numb=count;
						//interact.push(numb);
					}
					else{
						//document.getElementById('ycord').innerHTML=count;
					}
					count++;
					
					
				//}
			//}
		}
		document.getElementById('xcord').innerHTML=numb;
		
		
	}


	*/




		function pick_3d_cube(xqcord,yqcord,zqcord){



		//document.getElementById('ycord').innerHTML="count";
		
		var numb;
		var ss=String(xqcord)+"qw"+String(yqcord)+"qw"+String(zqcord);

		//document.getElementById('ycord').innerHTML=ss;
		
		var count = 0;

		for(var i=-5.5;i<5.5;i=i+0.4){
			
			for(var j=-6.5;j<6.3;j=j+0.4){
				
				for(var k=-10.6;k<10.6;k=k+0.4){
					

					if(((xqcord>i && xqcord<(i+0.4)) && (yqcord>j && yqcord<(j+0.4))) || ((xqcord>i && xqcord<(i+0.4)) && (zqcord>k && zqcord<(k+0.4))) || ((yqcord>j && yqcord<(j+0.4)) && (zqcord>k && zqcord<(k+0.4))) ){
						//document.getElementById('ycord').innerHTML=count;
						numb=count;
					}
					else{
						//document.getElementById('ycord').innerHTML=count;
						//numb=count;
					}
					count++;
					
					
				}
			}
		}
		//document.getElementById('ycord').innerHTML=numb;
		return numb;
	}


	

	function get3dPoint(winX,winY) {


		
		var x = 2.0 * winX / 1000 - 1;
	   	var y = - 2.0 * winY / 500 + 1;

	   	var z = 0;


        mat4.identity(mvMatrix);

        mat4.rotate(mvMatrix, degToRad(-pitch), [1, 0, 0]);
        mat4.rotate(mvMatrix, degToRad(-yaw), [0, 1, 0]);
        
        var c = mat4.translate(mvMatrix, [-xPos, -yPos, -zPos]);

	   	//var viewProjectionInverse = mt4.create();
	   	e = mat4.inverse(c);

	   	var d = mat4.translate(e, [x, y, z]);
	   	
	   	//var b = String();
	   	
	   //	var b = viewProjectionInverse.length;
	   
	   var b = "";


	  // for(var i=0;i<d.length;i++){
		   b=b+d[12];
		   b=b+"<br/>";
		   b=b+d[13];
		   b=b+"<br/>";
		   b=b+d[14];
		   b=b+"<br/>";
	   //}
	   	
		//var b = String(viewProjectionInverse);
		
		var numb1=pick_3d_cube(d[12],d[13],d[14]);
		var numb=[];

		numb.push(numb1);
		
		//var tmp =[];
		//tmp.push(d[12]);
		//tmp.push(d[13]);
		//tmp.push(d[14]);
		if(recheckStatus==false){
			interact.push(numb);
		}
		else{
			interact_check.push(numb);
		}




		//var b = String(winX)+"--"+String(winY);
		//var b = String(x)+"--"+String(y);
		//var b = String(c);
		//document.getElementById('ycord').innerHTML=b;
		document.getElementById('xcord').innerHTML="Interaction Added";
		
		setTimeout(function(){document.getElementById('xcord').innerHTML="Please Make an Interaction.";},1000);
		

	}


    




    function set_textual_password() {

    	document.getElementById('text_pass_button').style.visibility = "hidden";
    	document.getElementById('pass1_text').style.visibility = "visible";
    	document.getElementById('pass2_text').style.visibility = "visible";
    	document.getElementById('ok_pass_button').style.visibility = "visible";
		
	}



	function password_box_manage(number){
		if(number==1){
			//document.getElementById('pass1_text').style.visibility = "hidden";
			var pass=document.getElementById('pass1');
			pass.value="";
			pass.type="password";
			pass.style.color="black";
			
			//pass1.type="password";
		}
		if(number==2){
			//document.getElementById('pass1_text').style.visibility = "hidden";
			var pass=document.getElementById('pass2');
			pass.value="";
			pass.type="password";
			pass.style.color="black";
			
			//pass1.type="password";
		}
	}

	function cancel_textual_password(){

		var pass;
		pass=document.getElementById('pass1');
		pass.value="       Enter Password";
		pass.type="text";
		pass.style.color="gray";

		pass=document.getElementById('pass2');
		pass.value="     Reenter Password";
		pass.type="text";
		pass.style.color="gray";

    	document.getElementById('text_pass_button').style.visibility = "visible";
    	document.getElementById('pass1_text').style.visibility = "hidden";
    	document.getElementById('pass2_text').style.visibility = "hidden";
    	document.getElementById('ok_pass_button').style.visibility = "hidden";
    	//document.getElementById('err_pass_msj').innerHTML="Textual password Added";
    	document.getElementById('err_pass_msj').style.color = "blue";
    	document.getElementById('err_pass_msj').style.visibility = "hidden";
		
		
	}

	function check_textual_password(){

		var pass;
		var pass1=document.getElementById('pass1').value;
		var pass2=document.getElementById('pass2').value;

		

		if(pass1=="" || pass2=="" || pass1!=pass2){
			//document.getElementById('ycord').innerHTML="Ssss";
			document.getElementById('err_pass_msj').style.visibility = "visible";
			document.getElementById('err_pass_msj').style.color="red";

			document.getElementById('err_pass_msj').innerHTML="Try anothe password.";

			pass=document.getElementById('pass1');
			pass.value="       Enter Password";
			pass.type="text";
			pass.style.color="gray";

			pass=document.getElementById('pass2');
			pass.value="     Reenter Password";
			pass.type="text";
			pass.style.color="gray";
		}

		else {
			//document.getElementById('ycord').innerHTML=pass1;
	    	document.getElementById('text_pass_button').style.visibility = "visible";
	    	document.getElementById('pass1_text').style.visibility = "hidden";
	    	document.getElementById('pass2_text').style.visibility = "hidden";
	    	document.getElementById('ok_pass_button').style.visibility = "hidden";
	    	document.getElementById('err_pass_msj').innerHTML="Textual password Added";
	    	document.getElementById('err_pass_msj').style.color = "blue";
	    	document.getElementById('err_pass_msj').style.visibility = "visible";
	    	var tmp =[];
	    	tmp.push("Textual-password");
	    	tmp.push(pass1);

			if(recheckStatus==false){
				interact.push(tmp);
			}
			else{
				interact_check.push(tmp);
			}

			setTimeout(function(){document.getElementById('err_pass_msj').style.visibility = "hidden";},3000);
			

			pass=document.getElementById('pass1');
			pass.value="       Enter Password";
			pass.type="text";
			pass.style.color="gray";

			pass=document.getElementById('pass2');
			pass.value="     Reenter Password";
			pass.type="text";
			pass.style.color="gray";
	    	
	    	
		}
		
	}

	var interact=[];
	var interact_check=[];

/*
	function print_selected_password(){
		var ad="";
		for(var i=0;i<interact.length;i++){
			ad=ad+interact[i];
			ad=ad+"--";
		}
		document.getElementById('ycord').innerHTML=ad;
	}*/



	var recheckStatus=false;
	
	



	function submit_selected_password(){
		var s="";

			//var flag=true;
			for(var i=0;i<interact.length;i++){
				if(interact[i][0]!="Textual-password"){

						s=s+"--";
						s=s+interact[i][0];
				}
				else{
					s=s+"+";
					s=s+interact[i][0];
					s=s+"+";
					s=s+interact[i][1];
					s=s+"+";
					s=s+interact[i][0];

				}

			}
			//if(flag==true){
				//document.getElementById('xcord').innerHTML="Congratz..!! 3D Password Matches ...!!!";

				var a= document.getElementById("password3d");

				a.value=s;


				//document.getElementById('ycord').innerHTML=s;
				
				document.myform.submit();

				
			//}
			//else{
				//document.getElementById('xcord').innerHTML="Sorry Try Again Another 3D Password..!!!!";
			//}



	}


    


    function webGLStart() {
        var canvas = document.getElementById("canv");
       // document.getElementById('xcord').innerHTML="Welcome...!!!"
        //document.getElementById('xcord').innerHTML="Please perform your password";
        initGL(canvas);
        initShaders();
        initTexture();
        initFloorTexture();
        initRoofTexture();
        initBackTexture();
        initFrontTexture();
        initLeftTexture();
        initRightTexture();
        //loadFloor();
        loadWorld();
        //loadFloor();
		
        gl.clearColor(0.0, 0.0, 0.0, 1.0);
        gl.enable(gl.DEPTH_TEST);

        document.onkeydown = handleKeyDown;
        document.onkeyup = handleKeyUp;

        canvas.onmousedown = handleMouseDown;
        document.onmouseup = handleMouseUp;
        document.onmousemove = handleMouseMove;
        
    

        tick();
    }


	function reload_check(){
		interact=[];
		//interact_check=[];
		//recheckStatus=false;
		document.getElementById('xcord').innerHTML="Please Make an Interaction.";
		
	}

	
	//var interact=[];
	//var interact_check=[];

	//var recheckStatus=false;
	
	





	function recheck_selected_password(){
		var s="";
		if(recheckStatus==true){
			var flag=true;

			//document.getElementById('xcord').innerHTML=interact.length
			
			//document.getElementById('xcord').innerHTML=interact[0][1];
			
			for(var i=0;i<interact.length;i++){
				if(interact[i][0]!="Textual-password"){

					//document.getElementById('xcord').innerHTML=interact[i][0];
					/*
					for(var j=0;j<2;j++){
						if(interact_check[i][j]<(interact[i][j]-0.3) || interact_check[i][j]>(interact[i][j]+0.3)){
							flag=false;
						}
					}
					*/
					/*
					s=s+"+";
					s=s+interact[i][0];
					s=s+"+";
					s=s+interact[i][1];
					s=s+"+";
					s=s+interact[i][2];
					//break;
					*/


					if(interact[i][0]!=interact_check[i][0]){
						flag=false;
					}

					else{

						s=s+"--";
						s=s+interact[i][0];
					}
					
				}
				else{
					if(interact[i][1]!=interact_check[i][1]){
						flag=false;
					}
					//else{
					
					//document.getElementById('xcord').innerHTML="DDD";
					
							s=s+"+";
							s=s+interact[i][0];
							s=s+"+";
							s=s+interact[i][1];
							s=s+"+";
							s=s+interact[i][0];

					//}
						
					
				}
				/*
				s=s+"+";
				s=s+interact[i][0];
				s=s+"+";
				s=s+interact[i][1];
				s=s+"+";
				s=s+interact[i][0];
				//break;

				*/
			}
			if(flag==true){
				document.getElementById('xcord').innerHTML="Congratz..!! 3D Password Matches ...!!!";

				var a= document.getElementById("password3d");

				a.value=s;


				//document.getElementById('ycord').innerHTML=s;
				
				document.myform.submit();

				

				

				
			}
			else{
				//setTimeout(function(){document.getElementById('xcord').innerHTML="Sorry Try Again Another 3D Password..!!!!";},4000);
				document.getElementById('xcord').innerHTML="Sorry Try Again Another 3D Password..!!!!";
				interact=[];
				interact_check=[];
				recheckStatus=false;
			}
		}
		else{
			//setTimeout(function(){document.getElementById('xcord').innerHTML="Please Reenter Your 3D Password.";},4000);
			
			document.getElementById('xcord').innerHTML="Please Reenter Your 3D Password.";
			
			recheckStatus=true;
		}
	}

	function reload_create(){
		interact=[];
		interact_check=[];
		recheckStatus=false;
		document.getElementById('xcord').innerHTML="";
		
	}

