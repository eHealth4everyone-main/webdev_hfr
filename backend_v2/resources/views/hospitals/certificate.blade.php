<!DOCTYPE html>
<html>
<head>
    <title>Certificate - {{ $hospital->facility_name }}</title>
    <style>
        @page { size: A4 landscape; margin: 0; }
        body { margin: 0; padding: 0; font-family: 'Source Sans Pro', sans-serif; background-color: #f8f9fa; }
        .certificate-container {
            width: 297mm;
            height: 210mm;
            padding: 15mm;
            box-sizing: border-box;
            background: white;
            position: relative;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            margin: 20px auto;
        }
        .border-pattern {
            position: absolute;
            top: 5mm;
            left: 5mm;
            right: 5mm;
            bottom: 5mm;
            border: 8px double #006400; /* Dark Green */
            padding: 5mm;
        }
        .inner-content {
            height: 100%;
            border: 1px solid #006400;
            padding: 10mm;
            text-align: center;
        }
        .header { margin-bottom: 15mm; }
        .header h1 { margin: 10px 0; color: #006400; font-size: 38pt; font-family: 'Georgia', serif; }
        .header h2 { margin: 5px 0; font-size: 18pt; text-transform: uppercase; letter-spacing: 4px; color: #333; }
        .header h3 { margin: 5px 0; font-size: 14pt; font-weight: normal; font-style: italic; }
        
        .main-text { font-size: 16pt; margin: 15mm 0; line-height: 1.8; color: #333; }
        .facility-name { font-size: 32pt; font-weight: bold; color: #000; margin: 8mm 0; text-decoration: underline; font-family: 'Times New Roman', serif; }
        .level-badge {
            display: inline-block;
            background: #006400;
            color: white;
            padding: 8px 25px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18pt;
            margin: 10px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
        
        .footer {
            position: absolute;
            bottom: 20mm;
            left: 25mm;
            right: 25mm;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }
        .signature-box { text-align: center; width: 70mm; }
        .signature-line { border-top: 2px solid #333; margin-bottom: 5px; }
        .signature-text { font-size: 11pt; color: #555; }
        
        .qr-placeholder {
            width: 35mm;
            height: 35mm;
            border: 2px solid #006400;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            background: #fdfdfd;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-35deg);
            font-size: 140pt;
            color: rgba(0, 100, 0, 0.03);
            pointer-events: none;
            z-index: 0;
            font-weight: bold;
            white-space: nowrap;
        }
        
        @media print {
            body { background: none; }
            .certificate-container { margin: 0; box-shadow: none; border: none; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align: center; padding: 25px; background: #333;">
        <button onclick="window.print()" style="padding: 12px 30px; font-size: 18px; cursor: pointer; background: #006400; color: white; border: none; border-radius: 5px; font-weight: bold;">
            <i class="fa fa-print"></i> Print Official Certificate
        </button>
        <p style="color: #ccc; margin-top: 10px;">Select "Landscape" in print settings for best results.</p>
    </div>

    <div class="certificate-container">
        <div class="watermark">NIGERIA HFR</div>
        <div class="border-pattern">
            <div class="inner-content">
                <div class="header">
                    <h2>Federal Republic of Nigeria</h2>
                    <h1>CERTIFICATE OF STANDARDS</h1>
                    <h3>Issued by the Nigeria Health Facility Registry</h3>
                </div>

                <div class="main-text">
                    This is to formally certify that the health facility known as
                    <div class="facility-name">{{ $hospital->facility_name }}</div>
                    located in <strong>{{ $hospital->lga }} LGA</strong>, <strong>{{ $hospital->state }} State</strong>,
                    <br>
                    has been evaluated and registered as a center of
                    <br>
                    <div class="level-badge">{{ $hospital->level_name }} LEVEL CARE</div>
                    <br>
                    in accordance with the National Standards for Health Facilities in Nigeria.
                </div>

                <div class="main-text" style="font-size: 13pt; margin-top: 10mm;">
                    <strong>CERTIFICATE NO:</strong> {{ $certificate->certificate_no }} &nbsp;&nbsp;|&nbsp;&nbsp; 
                    <strong>DATE ISSUED:</strong> {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d F Y') }}
                    <br>
                    <strong>EXPIRY DATE:</strong> {{ \Carbon\Carbon::parse($certificate->expiry_date)->format('d F Y') }}
                </div>

                <div class="footer">
                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-text">National Coordinator, NHFR</div>
                    </div>
                    
                    <div class="qr-placeholder">
                        <div style="font-size: 8pt; color: #006400; font-weight: bold;">VERIFY AUTHENTICITY</div>
                        <div style="margin: 5px 0;">[QR CODE]</div>
                        <div style="font-size: 7pt; color: #777;">HFR-VALID-{{ $hospital->id }}</div>
                    </div>

                    <div class="signature-box">
                        <div class="signature-line"></div>
                        <div class="signature-text">Director, Health Planning & Statistics</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
