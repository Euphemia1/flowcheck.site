from reportlab.lib.pagesizes import A4
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm

output_path = r"C:\Users\XPS\Desktop\euphemia_tickets_25_30_May_2026.pdf"

doc = SimpleDocTemplate(output_path, pagesize=A4,
    rightMargin=3*cm, leftMargin=3*cm, topMargin=3*cm, bottomMargin=3*cm)

styles = getSampleStyleSheet()
normal = styles['Normal']
normal.fontSize = 11
normal.leading = 18

story = []

story.append(Paragraph("Corelink", ParagraphStyle('co', parent=normal, fontSize=13, fontName='Helvetica-Bold')))
story.append(Spacer(1, 0.3*cm))
story.append(Paragraph("Weekly Resolved Tickets Report", ParagraphStyle('title', parent=normal, fontSize=14, fontName='Helvetica-Bold')))
story.append(Spacer(1, 0.2*cm))
story.append(Paragraph("Staff Member: Euphemia Chikungulu", normal))
story.append(Paragraph("Period: 25 May 2026 to 30 May 2026", normal))
story.append(Paragraph("Date Generated: 1 June 2026", normal))
story.append(Spacer(1, 0.5*cm))

story.append(Paragraph("During the week of 25 May 2026 to 30 May 2026, the following ticket was resolved by Euphemia Chikungulu:", normal))
story.append(Spacer(1, 0.4*cm))

story.append(Paragraph("Ticket #445", ParagraphStyle('tid', parent=normal, fontName='Helvetica-Bold')))
story.append(Paragraph("Subject: Results not Showing on Student Portal", normal))
story.append(Paragraph("Client: ZIPS", normal))
story.append(Paragraph("Submitted by: Nicholas Joseph Makumba (nicholasmakumba@gmail.com)", normal))
story.append(Paragraph("Date Opened: 22 May 2026", normal))
story.append(Paragraph("Date Resolved: 28 May 2026", normal))
story.append(Paragraph("Days to Resolve: 6 days", normal))
story.append(Paragraph("Status: Resolved", normal))

story.append(Spacer(1, 1*cm))
story.append(Paragraph("Total tickets resolved: 1", ParagraphStyle('bold', parent=normal, fontName='Helvetica-Bold')))

doc.build(story)
print(f"Saved to: {output_path}")
