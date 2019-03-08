
    // 加密
    function xxtea_encrypt(str, key) {
        if (str == "") {
            return "";
        }
        var v = str2long(str, true);
        var k = str2long(key, false);

        if (typeof str === 'string') str = toBytes(str);
        if (typeof key === 'string') key = toBytes(key);
        if (str === undefined || str === null || str.length === 0) {
            return str;
        }
        var v= toUint32Array(str, true);
        var k =  toUint32Array(key, false);

        var n = v.length - 1;
     
        var z = v[n], y = v[0], delta = 0x9E3779B9;
        var mx, e, q = Math.floor(6 + 52 / (n + 1)), sum = 0;
        while (q-- > 0) {
            sum = sum + delta & 0xffffffff;
            e = sum >>> 2 & 3;
            for (var p = 0; p < n; p++) {
                y = v[p + 1];
                mx = (z >>> 5 ^ y << 2) + (y >>> 3 ^ z << 4) ^ (sum ^ y) + (k[p & 3 ^ e] ^ z);
                z = v[p] = v[p] + mx & 0xffffffff;
            }
            y = v[0];
            mx = (z >>> 5 ^ y << 2) + (y >>> 3 ^ z << 4) ^ (sum ^ y) + (k[p & 3 ^ e] ^ z);
            z = v[n] = v[n] + mx & 0xffffffff;
        }
        return str2Hex(long2str(v, false));
    }

    // 解密
    function xxtea_decrypt(str, key) {
        if (str == "") {
            return "";
        }
        str = hex2str(str);
        var v = str2long(str, false);
        var k = str2long(key, false);

        var n = v.length - 1;
     
        var z = v[n - 1], y = v[0], delta = 0x9E3779B9;
        var mx, e, q = Math.floor(6 + 52 / (n + 1)), sum = q * delta & 0xffffffff;
        while (sum != 0) {
            e = sum >>> 2 & 3;
            for (var p = n; p > 0; p--) {
                z = v[p - 1];
                mx = (z >>> 5 ^ y << 2) + (y >>> 3 ^ z << 4) ^ (sum ^ y) + (k[p & 3 ^ e] ^ z);
                y = v[p] = v[p] - mx & 0xffffffff;
            }
            z = v[n];
            mx = (z >>> 5 ^ y << 2) + (y >>> 3 ^ z << 4) ^ (sum ^ y) + (k[p & 3 ^ e] ^ z);
            y = v[0] = v[0] - mx & 0xffffffff;
            sum = sum - delta & 0xffffffff;
        }

        var test= toUint8Array(v, true);
        //var test= new Array(97,98,99);
        return toString(test);
    }

   function long2str(v, w) {
        var vl = v.length;
        var sl = v[vl - 1] & 0xffffffff;
        for (var i = 0; i < vl; i++)
        {
            v[i] = String.fromCharCode(v[i] & 0xff,
                                       v[i] >>> 8 & 0xff,
                                       v[i] >>> 16 & 0xff, 
                                       v[i] >>> 24 & 0xff);
        }
        if (w) {
            return v.join('').substring(0, sl);
        } else {
            return v.join('');
        }
    }

    // 
    function str2long(s, w) {
        var len = s.length;
        var v = [];
        for (var i = 0; i < len; i += 4) {
            v[i >> 2] = s.charCodeAt(i)
                      | s.charCodeAt(i + 1) << 8
                      | s.charCodeAt(i + 2) << 16
                      | s.charCodeAt(i + 3) << 24;
        }
        if (w) {
            v[v.length] = len;
        }
        return v;
    }


    function str2Hex(input) {
        var output = ""; 
        var chr1 = ""; 
        var i = 0;
        do { 
            chr1 = input.charCodeAt(i++).toString(16); 
            if(chr1.length==1) {
                chr1="0"+chr1;
            }
            output+=chr1;
        } while (i < input.length);
        return output; 
    }

    function  hex2str(input) {
        var output="";
        var i=0;
        while(i<input.length){
            var k = parseInt(input.substr(i,1),16)<<4 | parseInt(input.substr(++i,1),16);
            k=k&255;
            output+=String.fromCharCode(k);
            ++i;
        }
        return output;
    }

    function toUint32Array(bytes, includeLength) {
        var length = bytes.length;
        var n = length >> 2;
        if ((length & 3) !== 0) {
            ++n;
        }
        var v;
        if (includeLength) {
            v = new Array(n + 1);
            v[n] = length;
        }
        else {
            v = new Uint32Array(n);
        }
        for (var i = 0; i < length; ++i) {
            v[i >> 2] |= bytes[i] << ((i & 3) << 3);
        }
        return v;
    }

    function toUint8Array(v, includeLength) {
        var n;
        if (includeLength) {
            n = v[v.length - 1];
        } else {
            n = v.length << 2;
        }

        var result = new Uint8Array(n);
        for (var i = 0; i < n; i++) {
            result[i] =  v[i >> 2] >> ((i & 3) << 3);
        }
        return result;
    }

    // str转byte数组
    function toBytes(str) {
        var n = str.length;
        // A single code unit uses at most 3 bytes.
        // Two code units at most 4.
        var bytes = new Uint8Array(n * 3);
        var length = 0;
        for (var i = 0; i < n; i++) {
            var codeUnit = str.charCodeAt(i);
            if (codeUnit < 0x80) {
                bytes[length++] = codeUnit;
            }
            else if (codeUnit < 0x800) {
                bytes[length++] = 0xC0 | (codeUnit >> 6);
                bytes[length++] = 0x80 | (codeUnit & 0x3F);
            }
            else if (codeUnit < 0xD800 || codeUnit > 0xDFFF) {
                bytes[length++] = 0xE0 | (codeUnit >> 12);
                bytes[length++] = 0x80 | ((codeUnit >> 6) & 0x3F);
                bytes[length++] = 0x80 | (codeUnit & 0x3F);
            }
            else {
                if (i + 1 < n) {
                    var nextCodeUnit = str.charCodeAt(i + 1);
                    if (codeUnit < 0xDC00 && 0xDC00 <= nextCodeUnit && nextCodeUnit <= 0xDFFF) {
                        var rune = (((codeUnit & 0x03FF) << 10) | (nextCodeUnit & 0x03FF)) + 0x010000;
                        bytes[length++] = 0xF0 | (rune >> 18);
                        bytes[length++] = 0x80 | ((rune >> 12) & 0x3F);
                        bytes[length++] = 0x80 | ((rune >> 6) & 0x3F);
                        bytes[length++] = 0x80 | (rune & 0x3F);
                        i++;
                        continue;
                    }
                }
                throw new Error('Malformed string');
            }
        }
        return bytes.subarray(0, length);
    }

    function toShortString(bytes, n) {
        var charCodes = new Array(n);
        var i = 0, off = 0;
        for (var len = bytes.length; i < n && off < len; i++) {
            var unit = bytes[off++];
            switch (unit >> 4) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
                charCodes[i] = unit;
                break;
            case 12:
            case 13:
                if (off < len) {
                    charCodes[i] = ((unit & 0x1F) << 6) |
                                    (bytes[off++] & 0x3F);
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            case 14:
                if (off + 1 < len) {
                    charCodes[i] = ((unit & 0x0F) << 12) |
                                   ((bytes[off++] & 0x3F) << 6) |
                                   (bytes[off++] & 0x3F);
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            case 15:
                if (off + 2 < len) {
                    var rune = (((unit & 0x07) << 18) |
                                ((bytes[off++] & 0x3F) << 12) |
                                ((bytes[off++] & 0x3F) << 6) |
                                (bytes[off++] & 0x3F)) - 0x10000;
                    if (0 <= rune && rune <= 0xFFFFF) {
                        charCodes[i++] = (((rune >> 10) & 0x03FF) | 0xD800);
                        charCodes[i] = ((rune & 0x03FF) | 0xDC00);
                    }
                    else {
                        throw new Error('Character outside valid Unicode range: 0x' + rune.toString(16));
                    }
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            default:
                throw new Error('Bad UTF-8 encoding 0x' + unit.toString(16));
            }
        }
        if (i < n) {
            charCodes = charCodes.slice(0, i);//charCodes.subarray(0, i);
        }
        return String.fromCharCode.apply(String, charCodes);
    }

    function toLongString(bytes, n) {
        var buf = [];
        var charCodes = new Array(0xFFFF);
        var i = 0, off = 0;
        for (var len = bytes.length; i < n && off < len; i++) {
            var unit = bytes[off++];
            switch (unit >> 4) {
            case 0:
            case 1:
            case 2:
            case 3:
            case 4:
            case 5:
            case 6:
            case 7:
                charCodes[i] = unit;
                break;
            case 12:
            case 13:
                if (off < len) {
                    charCodes[i] = ((unit & 0x1F) << 6) |
                                    (bytes[off++] & 0x3F);
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            case 14:
                if (off + 1 < len) {
                    charCodes[i] = ((unit & 0x0F) << 12) |
                                   ((bytes[off++] & 0x3F) << 6) |
                                   (bytes[off++] & 0x3F);
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            case 15:
                if (off + 2 < len) {
                    var rune = (((unit & 0x07) << 18) |
                                ((bytes[off++] & 0x3F) << 12) |
                                ((bytes[off++] & 0x3F) << 6) |
                                (bytes[off++] & 0x3F)) - 0x10000;
                    if (0 <= rune && rune <= 0xFFFFF) {
                        charCodes[i++] = (((rune >> 10) & 0x03FF) | 0xD800);
                        charCodes[i] = ((rune & 0x03FF) | 0xDC00);
                    }
                    else {
                        throw new Error('Character outside valid Unicode range: 0x' + rune.toString(16));
                    }
                }
                else {
                    throw new Error('Unfinished UTF-8 octet sequence');
                }
                break;
            default:
                throw new Error('Bad UTF-8 encoding 0x' + unit.toString(16));
            }
            if (i >= 65534) {
                var size = i + 1;
                buf.push(String.fromCharCode.apply(String, charCodes.subarray(0, size)));
                n -= size;
                i = -1;
            }
        }
        if (i > 0) {
            buf.push(String.fromCharCode.apply(String, charCodes.slice(0, i)));
        }
        return buf.join('');
    }

    function toString(bytes) {
        var n = bytes.length;
        if (n === 0) return '';
        return ((n < 100000) ? toShortString(bytes, n) : toLongString(bytes, n));
    }
