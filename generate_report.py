from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.units import cm
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Table, TableStyle
from reportlab.lib import colors
from reportlab.lib.enums import TA_CENTER, TA_LEFT

output_path = r"C:\Users\XPS\Desktop\flowcheck.ai\weekly_tickets_report_25_30_May_2026.pdf"

doc = SimpleDocTemplate(
    output_path,
    pagesize=A4,
    rightMargin=2*cm,
    leftMargin=2*cm,
    topMargin=2*cm,
    bottomMargin=2*cm
)

styles = getSampleStyleSheet()
story = []

# Custom styles
title_style = ParagraphStyle('CustomTitle', parent=styles['Title'], fontSize=16, spaceAfter=4)
subtitle_style = ParagraphStyle('Subtitle', parent=styles['Normal'], fontSize=10, spaceAfter=2)
heading_style = ParagraphStyle('Heading', parent=styles['Heading2'], fontSize=11, spaceBefore=12, spaceAfter=6)
normal_small = ParagraphStyle('NormalSmall', parent=styles['Normal'], fontSize=8)

# Header
story.append(Paragraph("CORELINK", ParagraphStyle('Company', parent=styles['Title'], fontSize=20, spaceAfter=2)))
story.append(Paragraph("Weekly Support Tickets Report", title_style))
story.append(Paragraph("Period: 25 May 2026 – 30 May 2026 (Monday to Friday)", subtitle_style))
story.append(Paragraph("Date Generated: 1 June 2026", subtitle_style))
story.append(Paragraph("Prepared by: euphemia@corelink.co.zm", subtitle_style))
story.append(Spacer(1, 0.4*cm))

# Divider
story.append(Table([['']], colWidths=[17*cm], style=TableStyle([('LINEABOVE', (0,0), (-1,0), 1, colors.black)])))
story.append(Spacer(1, 0.3*cm))

# SECTION 1: SUMMARY
story.append(Paragraph("1. SUMMARY", heading_style))
summary_data = [
    ["Metric", "Count"],
    ["Total Tickets Resolved This Week", "12"],
    ["Total Tickets Opened This Week (Still Open)", "12"],
    ["Total Tickets Worked On", "24"],
]
summary_table = Table(summary_data, colWidths=[12*cm, 5*cm])
summary_table.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
    ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
    ('FONTSIZE', (0,0), (-1,-1), 9),
    ('GRID', (0,0), (-1,-1), 0.5, colors.black),
    ('ROWBACKGROUND', (0,1), (-1,-1), [colors.white, colors.whitesmoke]),
    ('LEFTPADDING', (0,0), (-1,-1), 6),
    ('RIGHTPADDING', (0,0), (-1,-1), 6),
    ('TOPPADDING', (0,0), (-1,-1), 4),
    ('BOTTOMPADDING', (0,0), (-1,-1), 4),
]))
story.append(summary_table)
story.append(Spacer(1, 0.3*cm))

# SECTION 2: RESOLVED TICKETS
story.append(Paragraph("2. RESOLVED TICKETS (12 tickets)", heading_style))
resolved_data = [
    ["Ticket ID", "Subject", "Client", "Assigned To", "Created", "Resolved", "Days"],
    ["#341", "Link Student to Sage Account\nUsing Old Sage Database", "Levy Mwanawasa\nMedical University", "Rowan Vos", "24 Mar 2026", "29 May 2026", "66"],
    ["#345", "Migration of Edurole from\nOld Sage to New Sage", "Levy Mwanawasa\nMedical University", "Rowan Vos", "25 Mar 2026", "29 May 2026", "65"],
    ["#439", "Creation of a Balance Owing\nand Repayment Summary Tab", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "20 May 2026", "26 May 2026", "6"],
    ["#440", "Correction of Total Balances\non the Technician Summary", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "20 May 2026", "26 May 2026", "6"],
    ["#445", "Results not Showing on\nStudent Portal", "ZIPS", "Euphemia\nChikungulu", "22 May 2026", "28 May 2026", "6"],
    ["#448", "Repeat Courses Affiliation\nFee - Accounts Module", "Kafue Institute of\nHealth Sciences", "Waza Nyirenda", "22 May 2026", "28 May 2026", "6"],
    ["#449", "Outstanding Balances Filter\n- Accounts Module", "Kafue Institute of\nHealth Sciences", "Waza Nyirenda", "22 May 2026", "29 May 2026", "7"],
    ["#450", "Invoice Posting Failure After\nStudent Registration", "NORTEC", "Waza Nyirenda", "24 May 2026", "27 May 2026", "3"],
    ["#452", "Request to Restore Post Invoice\nand Push Payments Options", "NORTEC", "Waza Nyirenda", "28 May 2026", "28 May 2026", "0"],
    ["#461", "Permission Management", "ZIPS", "Wiza Siame", "29 May 2026", "29 May 2026", "0"],
    ["#463", "Addition of Column for RTGs\non the Daily Performance Register", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "29 May 2026", "29 May 2026", "0"],
    ["#464", "Removal of Rejected Bales\nfrom the Sales Summary", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "29 May 2026", "29 May 2026", "0"],
]
resolved_table = Table(resolved_data, colWidths=[1.5*cm, 4.5*cm, 3*cm, 2.5*cm, 2*cm, 2*cm, 1.2*cm])
resolved_table.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
    ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
    ('FONTSIZE', (0,0), (-1,-1), 7.5),
    ('GRID', (0,0), (-1,-1), 0.5, colors.black),
    ('VALIGN', (0,0), (-1,-1), 'TOP'),
    ('LEFTPADDING', (0,0), (-1,-1), 4),
    ('RIGHTPADDING', (0,0), (-1,-1), 4),
    ('TOPPADDING', (0,0), (-1,-1), 3),
    ('BOTTOMPADDING', (0,0), (-1,-1), 3),
    ('ROWBACKGROUND', (0,1), (-1,-1), [colors.white, colors.whitesmoke]),
]))
story.append(resolved_table)
story.append(Spacer(1, 0.3*cm))

# SECTION 3: OPEN TICKETS
story.append(Paragraph("3. OPEN TICKETS RAISED DURING THE WEEK (still pending)", heading_style))
open_data = [
    ["Ticket ID", "Subject", "Client", "Assigned To", "Created", "Status", "Age"],
    ["#453", "190102656 - Unable to Register", "Levy Mwanawasa\nMedical University", "Euphemia\nChikungulu", "28 May 2026", "Assigned", "4"],
    ["#454", "Error Registering 190102499", "Levy Mwanawasa\nMedical University", "Euphemia\nChikungulu", "28 May 2026", "Assigned", "4"],
    ["#455", "Error Registering 190104144", "Levy Mwanawasa\nMedical University", "Euphemia\nChikungulu", "28 May 2026", "Assigned", "4"],
    ["#456", "Unable to Register 220400003", "Levy Mwanawasa\nMedical University", "Euphemia\nChikungulu", "28 May 2026", "Assigned", "4"],
    ["#457", "Reminder on Inability to Load\nLabour Monies for Some Growers", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "28 May 2026", "Assigned", "4"],
    ["#458", "URGENT: Status of Inputs\nChanges when one input is edited", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "28 May 2026", "Assigned", "4"],
    ["#459", "Online Application Fee Payment\nOption Not Visible", "NORTEC", "Waza Nyirenda", "29 May 2026", "Assigned", "3"],
    ["#460", "Error When Reviewing Online\nApplicant Records - 2603001326", "NORTEC", "Waza Nyirenda", "29 May 2026", "Assigned", "3"],
    ["#462", "Exclusion of Inactive Items\non the Inventory Add Dropdown", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "29 May 2026", "In Progress", "3"],
    ["#465", "Correction of the Regional\nSummary in Input Recovery Report", "Buyleaf Tobacco\nCompany Zambia Ltd", "Kwibisa Mwene", "29 May 2026", "Assigned", "3"],
    ["#466", "Student and Staff ID Cards\nand Bulk Upload", "TVTC Luanshya", "Unassigned", "29 May 2026", "New", "3"],
    ["#467", "Student Unable to Register\nfor a Repeat Course", "Levy Mwanawasa\nMedical University", "Unassigned", "29 May 2026", "New", "3"],
]
open_table = Table(open_data, colWidths=[1.5*cm, 4.2*cm, 3*cm, 2.5*cm, 2*cm, 2*cm, 1.2*cm])
open_table.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
    ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
    ('FONTSIZE', (0,0), (-1,-1), 7.5),
    ('GRID', (0,0), (-1,-1), 0.5, colors.black),
    ('VALIGN', (0,0), (-1,-1), 'TOP'),
    ('LEFTPADDING', (0,0), (-1,-1), 4),
    ('RIGHTPADDING', (0,0), (-1,-1), 4),
    ('TOPPADDING', (0,0), (-1,-1), 3),
    ('BOTTOMPADDING', (0,0), (-1,-1), 3),
    ('ROWBACKGROUND', (0,1), (-1,-1), [colors.white, colors.whitesmoke]),
]))
story.append(open_table)
story.append(Spacer(1, 0.3*cm))

# SECTION 4: BY STAFF MEMBER
story.append(Paragraph("4. RESOLVED TICKETS BY STAFF MEMBER", heading_style))
staff_data = [
    ["Staff Member", "Tickets Resolved", "Ticket IDs"],
    ["Kwibisa Mwene", "4", "#439, #440, #463, #464"],
    ["Waza Nyirenda", "4", "#448, #449, #450, #452"],
    ["Rowan Vos", "2", "#341, #345"],
    ["Euphemia Chikungulu", "1", "#445"],
    ["Wiza Siame", "1", "#461"],
]
staff_table = Table(staff_data, colWidths=[6*cm, 4*cm, 7*cm])
staff_table.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
    ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
    ('FONTSIZE', (0,0), (-1,-1), 9),
    ('GRID', (0,0), (-1,-1), 0.5, colors.black),
    ('ROWBACKGROUND', (0,1), (-1,-1), [colors.white, colors.whitesmoke]),
    ('LEFTPADDING', (0,0), (-1,-1), 6),
    ('RIGHTPADDING', (0,0), (-1,-1), 6),
    ('TOPPADDING', (0,0), (-1,-1), 4),
    ('BOTTOMPADDING', (0,0), (-1,-1), 4),
]))
story.append(staff_table)
story.append(Spacer(1, 0.3*cm))

# SECTION 5: BY CLIENT
story.append(Paragraph("5. RESOLVED TICKETS BY CLIENT", heading_style))
client_data = [
    ["Client", "Tickets Resolved"],
    ["Buyleaf Tobacco Company Zambia Limited", "4"],
    ["Levy Mwanawasa Medical University", "2"],
    ["Kafue Institute of Health Sciences & Research", "2"],
    ["NORTEC", "2"],
    ["ZIPS", "2"],
]
client_table = Table(client_data, colWidths=[12*cm, 5*cm])
client_table.setStyle(TableStyle([
    ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
    ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
    ('FONTSIZE', (0,0), (-1,-1), 9),
    ('GRID', (0,0), (-1,-1), 0.5, colors.black),
    ('ROWBACKGROUND', (0,1), (-1,-1), [colors.white, colors.whitesmoke]),
    ('LEFTPADDING', (0,0), (-1,-1), 6),
    ('RIGHTPADDING', (0,0), (-1,-1), 6),
    ('TOPPADDING', (0,0), (-1,-1), 4),
    ('BOTTOMPADDING', (0,0), (-1,-1), 4),
]))
story.append(client_table)

story.append(Spacer(1, 0.5*cm))
story.append(Table([['']], colWidths=[17*cm], style=TableStyle([('LINEABOVE', (0,0), (-1,0), 0.5, colors.grey)])))
story.append(Spacer(1, 0.2*cm))
story.append(Paragraph("--- End of Report ---", ParagraphStyle('Footer', parent=styles['Normal'], fontSize=8, textColor=colors.grey, alignment=TA_CENTER)))

doc.build(story)
print(f"PDF saved to: {output_path}")
