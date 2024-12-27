import os
from flask import Flask, request, send_file
from flask_restful import Resource, Api
from werkzeug.utils import secure_filename
import subprocess

app = Flask(__name__)
api = Api(app)

UPLOAD_FOLDER = '/latex/tex'
PDF_FOLDER = '/latex/pdf'

if not os.path.exists(UPLOAD_FOLDER):
    os.makedirs(UPLOAD_FOLDER)

if not os.path.exists(PDF_FOLDER):
    os.makedirs(PDF_FOLDER)

class LaTeXToPDF(Resource):
    def post(self):
        if 'file' not in request.files:
            return {'error': 'No file part'}, 400
        
        file = request.files['file']
        if file.filename == '':
            return {'error': 'No selected file'}, 400
        
        if file and file.filename.endswith('.tex'):
            filename = secure_filename(file.filename)
            tex_path = os.path.join(UPLOAD_FOLDER, filename)
            pdf_path = os.path.join(PDF_FOLDER, os.path.splitext(filename)[0] + '.pdf')
            file.save(tex_path)
            try:
                # Run XeLaTeX using subprocess for better control
                process = subprocess.run(
                    ['xelatex', '-output-directory', PDF_FOLDER, tex_path],
                    stdout=subprocess.PIPE,
                    stderr=subprocess.PIPE
                )
                if process.returncode == 0:
                    # Success, return the PDF
                    os.remove(tex_path)  # Optionally remove the .tex file
                    return send_file(pdf_path, as_attachment=True)
                else:
                    # XeLaTeX error, log and return error message
                    return {'error': 'XeLaTeX failed', 'details': process.stderr.decode('utf-8')}, 500
            except Exception as e:
                return {'error': str(e)}, 500
        else:
            return {'error': 'Invalid file format, must be a .tex file'}, 400

api.add_resource(LaTeXToPDF, '/latex-to-pdf')

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)